<?php

use Illuminate\Support\Str;


function getColStrFromInsertQuery($sql)
{
    $sql = explode("VALUES", $sql);
    $cols = $sql[0];

    $cols = explode('(', $cols);
    $cols = $cols[1];

    $cols = Str::replaceFirst(')', "", $cols);
    $cols = trimComponentString($cols);

    return str_replace('`', '', $cols);

}

function getValStrFromInsertQuery($sql):array
{
    $sql = explode("VALUES", $sql);
    $vals = $sql[1];

    $vals = explode(')', $vals);
    $newVals = [];
    foreach ($vals as $item)
    {
        $vals = Str::replaceFirst('(', "", $item);
        $vals = trimComponentString($vals);
        array_push($newVals, $vals);
    }

    return $newVals;
}

function trimComponentString(string $component): string
{
    $component = str_replace(["'", ' ', "\n"], ['','',''], $component);
    if($component !== '' && $component[0] == ','){
        $component[0] = ' ';
        $component = str_replace(["'", ' ', "\n"], ['','',''], $component);
    }

    return $component;
}

function buildInsertQuery($sql):array
{
    $sCol = getColStrFromInsertQuery($sql);

    $sVals = getValStrFromInsertQuery($sql);
    array_pop($sVals);
    $cols = explode(',', $sCol);
    $totalCols = count($cols);

    $dataToBeCreated = [];
    foreach ($sVals as $key => $item)
    {
//        $item = Str::replaceFirst(',', "", $item);
//        $item = Str::replaceLast(',', "", $item);
        $valComponents = explode(',', $item);
        if(!checkColValMismatch($valComponents, $totalCols))
        {
            $data = [];
            foreach ($cols as $index => $col)
            {
                $data[$col] = $valComponents[$index];
            }

            array_push($dataToBeCreated, $data);
        }else{
            echo json_encode($cols);
            echo("\n");
            echo json_encode($item);
            echo("\n");
            echo("\n");

        }
    }

    return $dataToBeCreated;
}

function checkColValMismatch(array $val, int $totalCols): bool
{
    if(count($val) != $totalCols) return true;

    return false;
}



$sql = "INSERT INTO `orders` (`user_id`, `owner_id`, `discount_id`, `payment_method_id`, `amount`, `status`, `created_at`, `updated_at`, `address_id`, `unique_order_id`, `coupon_id`, `delivery_charge_id`, `delivery_charge`, `total_saved`, `wallet_reduction`, `cash_back`, `schedule`) VALUES
(411, NULL, NULL, 4, 780, 'delivered', '2021-05-30 04:54:55', '2021-05-30 04:54:55', 333, 'MAY3021954', NULL, 8, 50, 10, 0.00, 0.00, NULL)";


$sql = 'INSERT INTO `users` (`id`, `name`, `type`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `otp`, `is_verified`, `provider`, `provider_id`, `is_activated`) VALUES
(415, "Mohammad Enamul Karim", "customer", NULL, 1716608825, NULL, "$2y$10$pN6H20PQPKGgk/.D8R2bm.Ky6nrcAIGf8zlkS43abqVdGCo0jKpCK", NULL, "2021-05-31 07:20:55", "2021-05-31 07:21:25", "ED8688", 1, NULL, NULL, 1),
(414, "Md Soboj", "customer", NULL, NULL, NULL, "$2y$10$FfWFRW4AXqf4RkWcPtPfqOiD.qTeLRIjp94zIhraiG2ngxx20/SL.", NULL, "2021-05-30 15:47:12", "2021-05-30 15:47:12", NULL, 1, "facebook", "107694701527047", 1),
(413, "MD Bellal", "customer", NULL, NULL, NULL, "$2y$10$TUv/1R6f/UUo2WB8Tq5cTu8LuxcbvIt0hhBq/.iikRhvp6D37kZje", NULL, "2021-05-30 15:18:23", "2021-05-30 15:18:23", NULL, 1, "facebook", "309466510732310", 1),
(412, "Monir Nipun", "customer", NULL, NULL, NULL, "$2y$10$CTVC13ZCDksDHQPhV4ezweAq.MDWQodz4gG4hYwF06LsMrYDNlw0C", NULL, "2021-05-30 12:02:30", "2021-05-30 12:02:30", NULL, 1, "facebook", "3797478587041050", 1),
(411, "Younus Khan", "customer", NULL, NULL, NULL, "$2y$10$Jd3SLNRDKjGkeq/hSjoJpuVqvN4Nlg3LNXwFNBzodjfDPlMa1pmD6", NULL, "2021-05-30 04:46:54", "2021-05-30 04:46:54", NULL, 1, "facebook", "3892141667551414", 1),
(410, "Piyal", "customer", NULL, 1791221300, NULL, "$2y$10$ADQ8pn990WSF7g3dK9NHXu./YLoGaeA8Qhys2CXGk4ksSM8f6mM9a", NULL, "2021-05-29 10:42:01", "2021-05-29 10:42:29", "ED8429", 1, NULL, NULL, 1),
(409, "পরাজিত সৈনিক", "customer", NULL, NULL, NULL, "$2y$10$dNIidVmFqpmdcDCu0G8wf.YyTL0fBQpsARmUmH2CvpBd7HkeaCySa", NULL, "2021-05-29 06:42:24", "2021-05-29 06:42:24", NULL, 1, "facebook", "298381645290193", 1),
(408, "Tahiat Nawal", "customer", NULL, 1705577665, NULL, "$2y$10$23NfFyeGb11JFDz7RA3Lu.N.FHyVy08jjsoMJ0d3KLXpR7obkRH6i", NULL, "2021-05-28 09:50:24", "2021-05-28 09:50:44", "ED8750", 1, NULL, NULL, 1),
(407, "Md Rabiul Karim", "customer", NULL, 1713043068, NULL, "$2y$10$qAG5eSdWzyRsOn7tY3dD7.6kF3v7GiZ5F5coYJGZ4tNhfrqau4BX6", NULL, "2021-05-27 17:23:38", "2021-05-27 17:37:46", "ED6232", 1, NULL, NULL, 1),
(406, "MAHABUB HASAN", "customer", NULL, 1670192626, NULL, "$2y$10$LdOcFg3TaQa9AcRLUy28qun2BCexgHJJLyXDKk6lC./FuxoCg9xXm", NULL, "2021-05-26 10:51:08", "2021-05-26 10:51:34", "ED6328", 1, NULL, NULL, 1),
(405, "Raz", "customer", NULL, 1624968441, NULL, "$2y$10$aJ05/vaZ8p9VvvfFoDtU1OBL2vT.Qc9neo54N3sNZtsBojB8tnIhi", NULL, "2021-05-26 06:25:05", "2021-05-26 06:25:48", "ED8144", 1, NULL, NULL, 1),
(404, "Rodela Ahmed", "customer", NULL, NULL, NULL, "$2y$10$Sh3IImGf0.yMNi46g9o7/.Ku0RU0fJM1jF/WLjB/SuD1m51DKGcem", NULL, "2021-05-26 06:00:46", "2021-05-26 06:00:46", NULL, 1, "facebook", "1139272436564679", 1),
(403, "Aynal Haque", "customer", NULL, NULL, NULL, "$2y$10$otgLUjn00WkNvPniHYJNU.jV4suCKc3RrP57fgzVUFVYMNDunX2Lq", NULL, "2021-05-25 13:19:14", "2021-05-25 13:19:14", NULL, 1, "facebook", "1994566904035282", 1),
(402, "আয়নাল হক", "customer", NULL, 1916043733, NULL, "$2y$10$uKrAA3CJOjOAlDHK/8STkeTQW9qcnSgRiqHY0TmfS4ZFxcK.fMasS", NULL, "2021-05-25 13:17:51", "2021-05-25 13:17:51", "ED4148", 0, NULL, NULL, 1),
(401, "Abdullah Al Mahdi", "customer", NULL, NULL, NULL, "$2y$10$lgjKTgpt0LhRDlBct4sB.eDd5lKINjj0a0Rbea0fgZ4n5AfeUFTu.", NULL, "2021-05-25 11:35:01", "2021-05-25 11:35:01", NULL, 1, "facebook", "116196357312065", 1),
(400, "Sanjida Hoque", "customer", NULL, 1521436052, NULL, "$2y$10$liJn92cFALiax16SUPoB5uj6wpbAbB23BcrixaOyvxs3uh/eLRE2u", NULL, "2021-05-25 11:17:45", "2021-05-25 11:18:25", "ED3429", 1, NULL, NULL, 1),
(399, "Jack Callahan", "customer", NULL, NULL, NULL, "$2y$10$m46xqhQgSSX1WjEmH0wnn.Zuaf.JjyMSRthaVWfGd04mjq2na4MIy", NULL, "2021-05-25 01:18:41", "2021-05-25 01:18:41", NULL, 1, "facebook", "10150004223863516", 1),
(398, "vaynecooler", "customer", NULL, NULL, NULL, "$2y$10$al9HZDKPr1oVmDLotQlgJuUr5a91mPWPURASeKkhovITExb1CITUm", NULL, "2021-05-25 01:03:22", "2021-05-25 01:03:22", NULL, 1, "facebook", "23002200457506", 1),
(397, "Abdullah Al Sadi", "customer", NULL, NULL, NULL, "$2y$10$zAvhzleWqhL8orvslD4v7e7rofUxb2JfpbbLzrUVQMYrI4Rtp8GLy", NULL, "2021-05-24 16:06:59", "2021-05-26 15:52:10", NULL, 1, "facebook", "1134157430431590", 1),
(396, "Fatema Binte Jahangir", "customer", NULL, 1778558855, NULL, "$2y$10$AQCMLW63PxRsZRjs4KJGber5WMQWpAJD2pX2FKG8/hd/DX15pih3q", NULL, "2021-05-24 08:36:10", "2021-05-24 08:38:32", "ED8654", 1, NULL, NULL, 1),
(395, "Rumana", "customer", NULL, 1713032794, NULL, "$2y$10$iSksPb4UfL9nmav/QsMPleTvUt4jHlC.qPcLVlaNo7KAeENO64Nwq", NULL, "2021-05-22 12:30:29", "2021-05-22 12:31:24", "ED8613", 1, NULL, NULL, 1),
(394, "মনিশা আক্তার", "customer", NULL, NULL, NULL, "$2y$10$kEVeshdLZorJe4fQjzjOduj0geNEEjgTL9ZGzrCHQahKPsd5y3ava", NULL, "2021-05-22 12:18:46", "2021-05-22 12:18:46", NULL, 1, "facebook", "115125170738028", 1),
(393, "Ziaul Hoque", "customer", NULL, NULL, NULL, "$2y$10$8Fp8/sCFDAKKXoXtazvtw.LMsVg.YSO2mQNKWy5xDTuVZ7y8P11jO", NULL, "2021-05-22 10:31:23", "2021-05-22 10:31:23", NULL, 1, "facebook", "1610412919149960", 1),
(392, "Sharmin", "customer", NULL, 1726711395, NULL, "$2y$10$Cbf5AlVBJWNGN36VpP9g5eS5OW5sJiQV9vu/Qlg7YTgvXhdYQZYP2", NULL, "2021-05-22 05:47:30", "2021-05-22 05:47:30", "ED6463", 0, NULL, NULL, 1),
(391, "Rokeya Sharmin", "customer", NULL, NULL, NULL, "$2y$10$XPVRtK8GFn..x0jOr.6KKea2/bAOtyl6x/tCXprTWdwOsltiHmb2a", NULL, "2021-05-22 05:40:49", "2021-05-22 05:40:49", NULL, 1, "facebook", "330579991791472", 1)';


dd(buildInsertQuery($sql));



