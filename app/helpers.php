<?php

function citiesToSelect($code = false, $placeholder = null)
{
    $cities = collect();
    $cities->push(collect(['name' => 'Adana', 'code' => 1]));
    $cities->push(collect(['name' => 'Adıyaman', 'code' => 2]));
    $cities->push(collect(['name' => 'Afyon', 'code' => 3]));
    $cities->push(collect(['name' => 'Ağrı', 'code' => 4]));
    $cities->push(collect(['name' => 'Aksaray', 'code' => 68]));
    $cities->push(collect(['name' => 'Amasya', 'code' => 5]));
    $cities->push(collect(['name' => 'Ankara', 'code' => 6]));
    $cities->push(collect(['name' => 'Antalya', 'code' => 7]));
    $cities->push(collect(['name' => 'Ardahan', 'code' => 75]));
    $cities->push(collect(['name' => 'Artvin', 'code' => 8]));
    $cities->push(collect(['name' => 'Aydın', 'code' => 9]));
    $cities->push(collect(['name' => 'Balıkesir', 'code' => 10]));
    $cities->push(collect(['name' => 'Bartın', 'code' => 74]));
    $cities->push(collect(['name' => 'Batman', 'code' => 72]));
    $cities->push(collect(['name' => 'Bayburt', 'code' => 69]));
    $cities->push(collect(['name' => 'Bilecik', 'code' => 11]));
    $cities->push(collect(['name' => 'Bingöl', 'code' => 12]));
    $cities->push(collect(['name' => 'Bitlis', 'code' => 13]));
    $cities->push(collect(['name' => 'Bolu', 'code' => 14]));
    $cities->push(collect(['name' => 'Burdur', 'code' => 15]));
    $cities->push(collect(['name' => 'Bursa', 'code' => 16]));
    $cities->push(collect(['name' => 'Çanakkale', 'code' => 17]));
    $cities->push(collect(['name' => 'Çankırı', 'code' => 18]));
    $cities->push(collect(['name' => 'Çorum', 'code' => 19]));
    $cities->push(collect(['name' => 'Denizli', 'code' => 20]));
    $cities->push(collect(['name' => 'Diyarbakır', 'code' => 21]));
    $cities->push(collect(['name' => 'Düzce', 'code' => 81]));
    $cities->push(collect(['name' => 'Edirne', 'code' => 22]));
    $cities->push(collect(['name' => 'Elazığ', 'code' => 23]));
    $cities->push(collect(['name' => 'Erzincan', 'code' => 24]));
    $cities->push(collect(['name' => 'Erzurum', 'code' => 25]));
    $cities->push(collect(['name' => 'Eskişehir', 'code' => 26]));
    $cities->push(collect(['name' => 'Gaziantep', 'code' => 27]));
    $cities->push(collect(['name' => 'Giresun', 'code' => 28]));
    $cities->push(collect(['name' => 'Gümüşhane', 'code' => 29]));
    $cities->push(collect(['name' => 'Hakkari', 'code' => 30]));
    $cities->push(collect(['name' => 'Hatay', 'code' => 31]));
    $cities->push(collect(['name' => 'Iğdır', 'code' => 76]));
    $cities->push(collect(['name' => 'Isparta', 'code' => 32]));
    $cities->push(collect(['name' => 'İstanbul', 'code' => 34]));
    $cities->push(collect(['name' => 'İzmir', 'code' => 35]));
    $cities->push(collect(['name' => 'Kahramanmaraş', 'code' => 46]));
    $cities->push(collect(['name' => 'Karabük', 'code' => 78]));
    $cities->push(collect(['name' => 'Karaman', 'code' => 70]));
    $cities->push(collect(['name' => 'Kars', 'code' => 36]));
    $cities->push(collect(['name' => 'Kastamonu', 'code' => 37]));
    $cities->push(collect(['name' => 'Kayseri', 'code' => 38]));
    $cities->push(collect(['name' => 'Kırıkkale', 'code' => 71]));
    $cities->push(collect(['name' => 'Kırklareli', 'code' => 39]));
    $cities->push(collect(['name' => 'Kırşehir', 'code' => 40]));
    $cities->push(collect(['name' => 'Kilis', 'code' => 79]));
    $cities->push(collect(['name' => 'Kocaeli', 'code' => 41]));
    $cities->push(collect(['name' => 'Konya', 'code' => 42]));
    $cities->push(collect(['name' => 'Kütahya', 'code' => 43]));
    $cities->push(collect(['name' => 'Malatya', 'code' => 44]));
    $cities->push(collect(['name' => 'Manisa', 'code' => 45]));
    $cities->push(collect(['name' => 'Mardin', 'code' => 47]));
    $cities->push(collect(['name' => 'Mersin', 'code' => 33]));
    $cities->push(collect(['name' => 'Muğla', 'code' => 48]));
    $cities->push(collect(['name' => 'Muş', 'code' => 49]));
    $cities->push(collect(['name' => 'Nevşehir', 'code' => 50]));
    $cities->push(collect(['name' => 'Niğde', 'code' => 51]));
    $cities->push(collect(['name' => 'Ordu', 'code' => 52]));
    $cities->push(collect(['name' => 'Osmaniye', 'code' => 80]));
    $cities->push(collect(['name' => 'Rize', 'code' => 53]));
    $cities->push(collect(['name' => 'Sakarya', 'code' => 54]));
    $cities->push(collect(['name' => 'Samsun', 'code' => 55]));
    $cities->push(collect(['name' => 'Siirt', 'code' => 56]));
    $cities->push(collect(['name' => 'Sinop', 'code' => 57]));
    $cities->push(collect(['name' => 'Sivas', 'code' => 58]));
    $cities->push(collect(['name' => 'Şanlıurfa', 'code' => 63]));
    $cities->push(collect(['name' => 'Şırnak', 'code' => 73]));
    $cities->push(collect(['name' => 'Tekirdağ', 'code' => 59]));
    $cities->push(collect(['name' => 'Tokat', 'code' => 60]));
    $cities->push(collect(['name' => 'Trabzon', 'code' => 61]));
    $cities->push(collect(['name' => 'Tunceli', 'code' => 62]));
    $cities->push(collect(['name' => 'Uşak', 'code' => 64]));
    $cities->push(collect(['name' => 'Van', 'code' => 65]));
    $cities->push(collect(['name' => 'Yalova', 'code' => 77]));
    $cities->push(collect(['name' => 'Yozgat', 'code' => 66]));
    $cities->push(collect(['name' => 'Zonguldak', 'code' => 67]));
    $cities->push(collect(['name' => 'Yurtdışı', 'code' => 0]));
    if ($code) {
        $result = $cities->pluck('name', 'code');
    } else {
        $result = $cities->pluck('name', 'name');
    }

    return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
}
