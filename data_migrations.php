<?php


function test_migration()
{
    echo "It's OK";
}

// Done
function channel_migration()
{
    $channels = App\Models\Channel::whereNotNull('logo')->get();
    $channels->each(function ($channel) {
        try {
            $channel
                ->addMedia(storage_path('app/public/channel/' . $channel->logo))
                ->sanitizingFileName(function ($fileName) use ($channel) {
                    return $channel->id . str_random(5) . '.' . explode('.', $fileName)[1];
                })
                ->toMediaCollection();
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage() . "\n";
            echo 'Channel #' . $channel->id . "\n";
        }
    });
}

// Done
function sponsor_migration()
{
    $sponsors = App\Models\Sponsor::whereNotNull('logo')->get();
    $sponsors->each(function ($sponsor) {
        try {
            $sponsor
                ->addMedia(storage_path('app/public/sponsor/' . $sponsor->logo))
                ->sanitizingFileName(function ($fileName) use ($sponsor) {
                    return $sponsor->id . str_random(5) . '.' . explode('.', $fileName)[1];
                })
                ->toMediaCollection();
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage() . "\n";
            echo 'Sponsor #' . $sponsor->id . "\n";
        }
    });
}

// Done
function user_role_migration()
{
    App\Models\User::chunk(100, function ($users) {
        $users->each(function ($user) {
            switch ($user->title) {
                case 'Yönetici':
                    $user->assignRole('admin');
                    break;
                case 'Fakülte Sorumlusu':
                    $user->assignRole('manager');
                    break;
                case 'Fakülte Yönetim Kurulu':
                    $user->assignRole('board');
                    break;
                case 'İletişim Sorumlusu':
                    $user->assignRole('relation');
                    break;
                case 'Site Sorumlusu':
                    $user->assignRole('website');
                    break;
                case 'Kan Bağışı Görevlisi':
                    $user->assignRole('blood');
                    break;
                case 'Hediye Sorumlusu':
                    $user->assignRole('gift');
                    break;
                default:
                    $user->assignRole('normal');
                    break;
            }
        });
    });
}

// approved_by -> approved_at
function user_approval_migration()
{
}

// Done
function user_image_migration()
{
    $users = App\Models\User::where('profile_photo', '<>', 'default')->get();
    $users->each(function ($user) {
        try {
            $user->addMedia(storage_path('app/public/profile/' . $user->profile_photo . '_l.jpg'), [], 'profile');
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage() . "\n";
            echo 'User #' . $user->id . "\n";
        }
    });
}

// Done
function faculty_migration()
{
    $faculties = App\Models\Faculty::all();
    $faculties->each(function ($faculty) {
        try {
            $faculty->addMedia(storage_path('app/public/faculty/' . $faculty->slug . '.png'));
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage() . "\n";
            echo 'Faculty #' . $faculty->id . "\n";
        }
    });
}

// Done
function post_image_migration()
{
    App\Models\Post::doesntHave('media')->with('images')->chunk(1000, function ($posts) {
        $posts->each(function ($post) {
            try {
                $post->images->each(function ($image) use ($post) {
                    $post->addMedia(storage_path('app/public/child/' . $image->name), ['ratio' => $image->ratio]);
                });
            } catch (\Exception $e) {
                echo 'Post #' . $post->id . "\n";
                echo 'Message: ' . $e->getMessage() . "\n";
            }
        });
    });

    App\Models\Child::whereIn('id', [1006,1007,1013,103,1041,1050,107,1079,1080,1103,1105,1107,1108,1110,1132,1164,118,1203,1204,1207,1208,12,1223,1228,12,123,1234,1237,1237,1257,1269,1270,1271,1272,1273,1279,1280,1293,1300,1302,1313,1314,1316,1317,1318,1319,1351,1354,1355,1356,1357,1358,1359,1360,1365,1367,139,1401,1412,1415,1421,1428,1429,1430,1431,1432,1433,1434,1435,1436,1437,1438,1439,1440,1441,1442,1443,1444,1445,1447,1449,1450,1453,1454,1455,1456,1457,1465,1466,1472,1473,1474,1476,1477,1505,1506,1507,1508,1509,1511,1512,1513,1514,1515,1516,1517,1517,1518,1519,1519,1520,1520,1521,1521,1522,1522,1523,1524,1524,1525,1525,1526,1526,1527,1527,1528,1528,1529,1530,1532,1532,1533,1533,1535,1535,1537,1537,1538,1540,1541,1542,1542,1543,1543,1544,1544,1545,1545,1546,1546,1548,1548,1550,1550,1551,1552,1552,1553,1553,1555,1558,1558,1559,1560,1561,1561,1562,1562,1563,1563,1565,1565,1566,1567,1568,1569,1569,1570,1571,1571,1572,1572,1573,1573,1575,1576,1576,1577,1577,1578,1578,1581,1582,1582,1583,1583,1584,1585,1585,1586,1586,1587,1587,1588,1588,1589,1589,1590,1590,1591,1591,1592,1592,1593,1593,1594,1594,1595,1595,1596,1597,1597,1598,1598,1599,1601,1601,1602,1602,1603,1604,1605,1605,1606,1606,1607,1608,1609,1609,1610,1610,1611,1612,1612,1613,1613,1614,1614,1615,1616,1616,1617,1617,1618,1618,1619,1619,1620,1620,1621,1621,1622,1622,1623,1623,1624,1625,1627,1627,1628,1628,1629,1629,16,1631,1632,1632,1633,1633,1634,1635,1635,1636,1636,1637,1637,1638,1638,1639,1639,1640,1640,1641,1641,1642,1667,1670,1677,1700,1731,1731,1794,1822,1824,1832,1834,1873,189,202,220,221,227,243,2436,2493,2511,26,292,293,294,295,296,2967,2969,2969,2970,2970,2971,2971,2972,2972,2973,2973,2974,2974,2975,2975,2976,2976,2977,2977,2978,2978,2979,2980,2980,2981,2981,2982,2982,2984,2984,2985,2985,2987,2987,2988,2988,2989,2989,2990,2990,2991,2991,2992,2992,2993,2993,2994,2995,2995,2996,2996,2997,2997,2998,2998,2999,2999,3000,3000,3001,3001,3002,3002,3003,3003,3004,3004,3005,3005,3006,3006,3007,3007,3009,3009,3010,3010,3012,3012,3013,3014,3014,3015,3015,3016,3016,3017,3017,3018,3018,3019,3020,3020,3021,3021,3022,3022,3023,3023,3024,3025,3027,3027,3028,3028,3029,3029,3030,3030,3031,3032,3032,3033,3033,3034,3034,3035,3035,3036,3036,3037,3037,3038,3038,3039,3039,3040,3040,3041,3041,3042,3042,3043,3043,3044,3044,3045,3045,3046,3046,3047,3048,3048,3049,3049,3050,3050,3051,3051,3052,3052,3053,3053,3054,3054,3058,3058,3059,3059,3060,3060,3061,3061,3062,3062,3063,3063,3064,3065,3065,3066,3067,3067,3068,3068,3069,3069,3070,3070,3071,3071,3072,3072,3073,3073,3074,3075,3075,3076,3076,3077,3077,3078,3078,3079,3079,3080,3080,3081,3081,3267,3307,332,3478,351,357,359,361,362,364,366,367,368,371,375,380,3848,3848,3849,39,39,40,404,406,4,425,427,441,447,448,455,456,461,465,470,470,473,474,475,493,493,495,5,527,528,530,536,538,580,615,616,6,627,628,646,654,656,657,659,661,662,663,67,686,733,736,754,762,800,802,81,820,82,825,833,833,835,901,908,909,913,914,915,946,947,948,949,950,951,952,953,954,96,97,977,978,979,98,984,988,989,990,991])->has('meetingPost')->each(function ($c){ echo $c->meetingPost->media->count() . "\n"; });
    $i = 0;
    App\Models\PostImage::doesntHave('post.child.meetingPost.media')->with('post', 'post.child', 'post.child.meetingPost')->chunk(1000, function ($images) use (&$i) {
        $images->each(function ($image) use (&$i) {
            try {
                $i++;
                echo $i . "\n";
                $image->post->child->meetingPost->addMedia(storage_path('app/public/child/' . $image->name), ['ratio' => $image->ratio]);

//                if ($image->post->child->meetingPost ?? false) {
//                    $path = storage_path('app/public/child/' . $image->name);
//                    echo file_exists($path);
//                    if (file_exists($path)) {
//                        $i++;
//                        echo $path . "\n";
//                        echo $i . "\n";
//                    }
//                }

            } catch (\Exception $e) {
                echo 'Post #' . $image->id . "\n";
                echo 'Message: ' . $e->getMessage() . "\n";
            }
        });
    });
}

function child_featured_img_migration()
{
    App\Models\Child::doesntHave('featuredMedia')->with('meetingPost', 'meetingPost.media', 'deliveryPost', 'deliveryPost.media')->get()->each(function ($child) {
        try {
            if ($child->deliveryPost && $child->deliveryPost->media) {
                $child->featuredMedia()->associate($child->deliveryPost->media->first());
                $child->save();
                return;
            }

            if ($child->meetingPost && $child->meetingPost->media) {
                $child->featuredMedia()->associate($child->meetingPost->media->first());
                $child->save();
                return;
            }
            echo 'No Image #' . $child->id . "\n";
        } catch (\Exception $e) {
            echo 'Child #' . $child->id . "\n";
            echo 'Message: ' . $e->getMessage() . "\n";
        }
    });
}

// done
function post_child_migration()
{
    App\Models\Post::with('child')->chunk(1000, function ($posts) {
        $posts->each(function ($post) {
            if (is_null($post->child)) {
                echo "NULL child - post: #{$post->id} child: #{$post->child_id} \n";
                return;
            }
            if ($post->type == App\Enums\PostType::Meeting) {
                $post->child->meetingPost()->associate($post);
                $post->child->save();
            } elseif ($post->type == App\Enums\PostType::Delivery) {
                $post->child->deliveryPost()->associate($post);
                $post->child->save();
            }
        });
    });
}

// done
function child_verification_migration()
{
    App\Models\Child::whereNotNull('verification_doc')->get()->each(function ($child) {
        try {
            $child->addVerificationDoc(storage_path('app/public/verification/' . $child->verification_doc));
            // $child->addMedia(storage_path('app/public/verification/' . $child->verification_doc), [], 'verification');
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage() . "\n";
            echo 'Verification #' . $child->id . "\n";
        }
    });
}