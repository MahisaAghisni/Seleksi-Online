<?php

use App\Models\Instrukturpelatihan;

function check_pelatihan($id_instruktur, $id_pelatihan)
{

    $where = [
        'instruktur_id' => $id_instruktur,
        'pelatihan_id' => $id_pelatihan,
    ];

    $result = Instrukturpelatihan::where($where)->get();

    if (count($result) > 0) {
        return "checked='checked'";
    }
}
