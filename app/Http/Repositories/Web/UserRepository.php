<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\UserInterface;
use App\Mail\UserEmail;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserRepository implements UserInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index($request)
    {
        $query = User::where('role_id', '!=', 1);

        if ($request->filled('filters')) {
            foreach ($request->filters as $index => $filter) {
                $index
                    ? $this->applyFilter($query, $filter)
                    : $this->firstFilter($query, $filter);
            }
        }

        $users = $query->with([
            'media', 'carLicense', 'wallet', 'garage_data'
        ])->paginate(10);

        return view('settings.users.index', ['dataTable' => $users, 'filters' => $this->getFilters()]);
    }

    public function user($user)
    {
        $users = User::where('role_id', '!=', 1)->where('id', $user->id)->paginate(10);

        return view('settings.users.index', ['dataTable' => $users, 'filters' => $this->getFilters()]);
    }

    public function create()
    {
        $roles = [
            2 => trans('lang.customer'),
            3 => trans('lang.winch'),
            4 => trans('lang.garage'),
        ];
        return view('settings.users.create', compact('roles'));
    }

    public function store($request)
    {
        $requestData = $request->validated();
        $requestData['password'] = Hash::make($request->input('password'));
        $requestData['short_biography'] = strip_tags($request->input('short_biography'));

        $user = User::create($requestData);
        switch ($user->role_id) {
            case 2:
                $user->user_information()->create($requestData);
                break;
            case 3:
                $user->winch_information()->create($requestData);
                break;
            case 4:
                $requestData['garage_type'] = 'none';
                $user->garage_information()->create($requestData);
                break;
        }
        if ($request->hasFile('image')) {
            $user->media()->create([
                'type' => 'user',
                'image' => $this->imageService->store($request->image, 'accounts', 'Provider')
            ]);
        }

        return redirect()->route('users.index')->withSuccess(trans('lang.created_success'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id)->load([
            'media', 
            'carLicense', 
            'wallet', 
            'garage_data' => fn ($query) => $query->withCount('services'),
            'bookingAds', 
            'carReports'
        ])->loadCount([
            'bookingAds', 
            'carReports'
        ])->loadUserInfo();
                
        return view('settings.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $userInfo = $user->info();
        if ($userInfo) {
            $user->setAttribute('phone_number', $userInfo->phone_number);
            $user->setAttribute('short_biography', $userInfo->short_biography);
            $user->setAttribute('address', $userInfo->address);
        }
        $roles = [
            2 => trans('lang.customer'),
            3 => trans('lang.winch'),
            4 => trans('lang.garage'),
        ];
        return view('settings.users.edit', compact('user', 'roles'));
    }

    public function update($request, $id)
    {
        $user = User::findOrFail($id);
        $requestData = $request->validated();
        $requestData['short_biography'] = strip_tags($request->input('short_biography'));

        $user->update($requestData);
        $user->info()->update($requestData);
        if ($request->hasFile('image')) {
            $user->media()->updateOrCreate([
                'type' => 'user'
            ], [
                'image' => $this->imageService->update($user->media()->first()?->imageName(), $request->image, 'accounts', 'Provider')
            ]);
        }

        return redirect()->route('users.index')->withSuccess(trans('lang.updated_success'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $this->imageService->delete($user->media()->first()?->imageName(), 'accounts');
        $user->media()->delete();
        $user->info()->delete();
        $user->delete();

        return redirect()->route('users.index')->withSuccess(trans('lang.deleted_success'));
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->update(['ban' => true]);
        return redirect()->route('users.index')->withWarning(trans('lang.banned_success'));
    }

    public function unban($id)
    {
        $user = User::findOrFail($id);
        $user->update(['ban' => false]);
        return redirect()->route('users.index')->withWarning(trans('lang.unbanned_success'));
    }

    public function message($request)
    {
        $data = $request->validated();

        foreach ($data['users'] as $userId) {
            $user = User::find($userId);

            Mail::send('settings.users.message',  ['otp' => $data['message']], function ($message) use ($data, $user) {
                $message->to($user->email)->subject('Dr.Car');
            });
        }

        return redirect()->route('users.index')->withSuccess(trans('lang.message_send_success'));
    }

    ############################# Helpers ################################

    protected function getFilters()
    {
        return [
            'customer' => trans('lang.customer'),
            'winch' => trans('lang.winch'),
            'garage' => trans('lang.garage'),
            // 'wallet' => trans('lang.wallet_has'),
            // 'carLicense' => trans('lang.car_has'),
        ];
    }

    protected function applyFilter($query, $filter)
    {
        match ($filter) {
            'customer' => $query->orWhere('role_id', 2),
            'winch' => $query->orWhere('role_id', 3),
            'garage' => $query->orWhere('role_id', 4),
                // 'wallet' => $query->orWhereHas('wallet'),
                // 'carLicense' => $query->orWhereHas('carLicense'),
            default => null,
        };
    }

    protected function firstFilter($query, $filter)
    {
        match ($filter) {
            'customer' => $query->where('role_id', 2),
            'winch' => $query->where('role_id', 3),
            'garage' => $query->where('role_id', 4),
                // 'wallet' => $query->whereHas('wallet'),
                // 'carLicense' => $query->whereHas('carLicense'),
            default => null,
        };
    }
}
