<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Admin\Service;
use App\Models\GarageData;
use App\Models\GarageInformation;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    private $baseUrl;
    
    public function __construct()
    {
        $this->baseUrl = rtrim(config('app.url'), '/');
        if (strpos($this->baseUrl, 'localhost') !== false && strpos($this->baseUrl, ':') !== false) {
            $this->baseUrl .= ':8000';
        }
        $this->baseUrl .= '/api/images';
    }

    public function run()
    {
        $WorkshopData = [
            [
                'name' => 'Car Lynx',
                'email' => 'car.lynx@drcar.me',
                'phone_number' => '0507669373',
                'address' => 'Al Quoz Industrial Area 1',
                'latitude' => 25.145980515583094,
                'longitude' => 55.230131138179736,
            ],
            [
                'name' => 'Al Hashmi Technical Work',
                'email' => 'street.king.auto.garage@drcar.me',
                'phone_number' => '0526581436',
                'address' => 'Al Quoz Industrial Area 4',
                'latitude' => 25.116446632184864,
                'longitude' => 55.234086641985805,
            ],
            [
                'name' => 'Axis AutoGarage',
                'email' => 'axis.autogarage@drcar.me',
                'phone_number' => '0522976056',
                'address' => 'Al Quoz Industrial Area 3',
                'latitude' => 25.12705763154225,
                'longitude' => 55.21732722879333,
            ],
            [
                'name' => 'AVC Auto Garage',
                'email' => 'avc.auto.garage@drcar.me',
                'phone_number' => '0542477878',
                'address' => 'Al Quoz Industrial Area 1',
                'latitude' => 25.145980515583094,
                'longitude' => 55.230131138179736,
            ],
            [
                'name' => 'Alif',
                'email' => 'alif@drcar.me',
                'phone_number' => '0565026631',
                'address' => 'Ras Al Khoor Industrial Area 2',
                'latitude' => 25.179893519028518,
                'longitude' => 55.35617329846421,
            ]
            // ,
            // [
            //     'name' => '800 Battery',
            //     'email' => '800.battery@drcar.me',
            //     'phone_number' => '0554186707',
            //     'address' => 'Dubai Investment Park 2',
            //     'latitude' => 24.97430639330147,
            //     'longitude' => 55.19795139563988,
            // ],
            // [
            //     'name' => 'Tube Wash',
            //     'email' => 'tube.wash@drcar.me',
            //     'phone_number' => '0526443903',
            //     'address' => 'Al Quoz Industrial Area 3',
            //     'latitude' => 25.12705763154225,
            //     'longitude' => 55.21732722879333,
            // ],
            // [
            //     'name' => 'DME Auto Repairing',
            //     'email' => 'dme.auto.repairing@drcar.me',
            //     'phone_number' => '0501188452',
            //     'address' => 'Al Quoz Industrial Area 1',
            //     'latitude' => 25.145980515583094,
            //     'longitude' => 55.230131138179736,
            // ],
            // [
            //     'name' => 'Kamdhenu Star Car Care ( Perma Guard )',
            //     'email' => 'kamdhenu.star.car.care@drcar.me',
            //     'phone_number' => '0506321408',
            //     'address' => 'Al Quoz Industrial Area 2',
            //     'latitude' => 25.13573922627684,
            //     'longitude' => 55.24556291726212,
            // ],
            // [
            //     'name' => 'Pupil Of Fate',
            //     'email' => 'pupil.of.fate@drcar.me',
            //     'phone_number' => '0507200512',
            //     'address' => 'Al Quoz Industrial Area 1',
            //     'latitude' => 25.145980515583094,
            //     'longitude' => 55.230131138179736,
            // ],
            // [
            //     'name' => 'DS2 Automotive',
            //     'email' => 'ds2.automotive@drcar.me',
            //     'phone_number' => '0586379791',
            //     'address' => 'Al Quoz Indudtrial Area 1',
            //     'latitude' => 25.145980515583094,
            //     'longitude' => 55.230131138179736,
            // ],
            // [
            //     'name' => 'Intensive Car Care',
            //     'email' => 'intensive.car.care@drcar.me',
            //     'phone_number' => '0521408520',
            //     'address' => 'Al Quoz Industrial Area 3',
            //     'latitude' => 25.12705763154225,
            //     'longitude' => 55.21732722879333,
            // ],
            // [
            //     'name' => 'Rukn Al Baraq',
            //     'email' => 'rukn.al.baraq@drcar.me',
            //     'phone_number' => '0543696252',
            //     'address' => 'Sharjah Industrial Area 13',
            //     'latitude' => 25.310277150396455,
            //     'longitude' => 55.44112828701258,
            // ],
            // [
            //     'name' => 'EXO Exclusive Auto Care',
            //     'email' => 'exo.exclusive.auto.care@drcar.me',
            //     'phone_number' => '0565628081',
            //     'address' => 'Al Quoz Industrial Area 1',
            //     'latitude' => 25.145980515583094,
            //     'longitude' => 55.230131138179736,
            // ],
            // [
            //     'name' => 'Directed Auto Accessories',
            //     'email' => 'directed.auto.accessories@drcar.me',
            //     'phone_number' => '0529798935',
            //     'address' => 'Umm Ramool',
            //     'latitude' => 25.228981682734474,
            //     'longitude' => 55.366875926204116,
            // ],
            // [
            //     'name' => 'Noor Al Madeena',
            //     'email' => 'noor.al.madeena@drcar.me',
            //     'phone_number' => '0549966086',
            //     'address' => 'Umm Ramool',
            //     'latitude' => 25.228981682734474,
            //     'longitude' => 55.366875926204116,
            // ],
            // [
            //     'name' => 'Carsaaz Auto Care Center',
            //     'email' => 'carsaaz.auto.care.center@drcar.me',
            //     'phone_number' => '0528353529',
            //     'address' => 'Diera',
            //     'latitude' => 25.279880245780323,
            //     'longitude' => 55.33024287061759,
            // ],
            // [
            //     'name' => 'Auto Studio',
            //     'email' => 'auto.studio@drcar.me',
            //     'phone_number' => '042843949',
            //     'address' => 'Al Quoz Indudtrial Area 1',
            //     'latitude' => 25.145980515583094,
            //     'longitude' => 55.230131138179736,
            // ],
            // [
            //     'name' => 'Manarat Al Ibdaa',
            //     'email' => 'manarat.al.ibdaa@drcar.me',
            //     'phone_number' => '058699311',
            //     'address' => 'Sharjah Industrial Area 13',
            //     'latitude' => 25.310277150396455,
            //     'longitude' => 55.44112828701258,
            // ],
            // [
            //     'name' => 'Royal Prince',
            //     'email' => 'royal.prince@drcar.me',
            //     'phone_number' => '0509487497',
            //     'address' => 'DIP',
            //     'latitude' => 24.97902451766667,
            //     'longitude' => 55.203095301658195,
            // ],
            // [
            //     'name' => 'Kinetic',
            //     'email' => 'kinetic@drcar.me',
            //     'phone_number' => '0552301123',
            //     'address' => 'DIP',
            //     'latitude' => 24.97902451766667,
            //     'longitude' => 55.203095301658195,
            // ],
            // [
            //     'name' => 'Qucik pro auto',
            //     'email' => 'qucik.pro.auto@drcar.me',
            //     'phone_number' => '0563724378',
            //     'address' => 'Al Qouz',
            //     'latitude' => 25.134562662672423,
            //     'longitude' => 55.23643076801979,
            // ],
            // [
            //     'name' => 'The Car Man',
            //     'email' => 'the.car.man@drcar.me',
            //     'phone_number' => '0505570804',
            //     'address' => 'Al Qouz',
            //     'latitude' => 25.134562662672423,
            //     'longitude' => 55.23643076801979,
            // ],
            // [
            //     'name' => 'One of one',
            //     'email' => 'one.of.one@drcar.me',
            //     'phone_number' => null,
            //     'address' => 'Al Qouz',
            //     'latitude' => 25.134562662672423,
            //     'longitude' => 55.23643076801979,
            // ],
            // [
            //     'name' => 'Ahmed Hussain',
            //     'email' => 'ahmed.hussain@drcar.me',
            //     'phone_number' => '0557011585',
            //     'address' => 'Umm Ramool',
            //     'latitude' => 25.228981682734474,
            //     'longitude' => 55.366875926204116,
            // ],
            // [
            //     'name' => 'Pro Dent',
            //     'email' => 'pro.dent@drcar.me',
            //     'phone_number' => null,
            //     'address' => 'Mamzar',
            //     'latitude' => 25.316912180124685,
            //     'longitude' => 55.335416973917795,
            // ],
        ];

        foreach ($WorkshopData as $i => $data) {
            $user = User::create([
                'full_name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => '2023-09-15 15:43:17',
                'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO',
                'role_id' => 4,
                'ban' => 0,
            ]);
            GarageInformation::create([
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
                'phone_verified_at' => '2023-11-17 14:30:43',
                'garage_id' => $user->id,
            ]);
            $address = Address::firstOrCreate([
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude']
            ], [
                'address' => $data['address'],
                'user_id' => $user->id
            ]);
            $eProvider = GarageData::create([
                'name' => $data['name'],
                'availability_range' => 5,
                'garage_id' => $user->id,
                'garage_type' => 0, // private
                'tax_id' => 1,
                'address_id' => $address->id,
                'check_servic_id' => 0, // updated later
            ]);
            $service = Service::create([
                'name' => 'check service',
                'price' => 100,
                'price_unit' => 1, // hourly
                'featured' => true,
                'enable_booking' => true,
                'available' => true,
                'provider_id' => $eProvider->id
            ]);
            $eProvider->update(['check_servic_id' => $service->id]);

            if ($i < 5) {
                Media::create([
                    'type' => 'user',
                    'type_id' => $user->id,
                    'image' => "$this->baseUrl/Provider/($i).jpg"
                ]);
                
                Media::create([
                    'type' => 'service',
                    'type_id' => $service->id,
                    'image' => "$this->baseUrl/Service/($i).jpg"
                ]);
            }
        }
    }
}
