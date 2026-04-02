<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class profilController extends Controller
{
    public function index(): void{
        echo "Nama saya ", request(key: 'nama');
        echo "<br>";
        echo " Umur " , request(key: "umur");
        // return "Hallo saya adalah bukti dari index dalam Profil. ";

    }

    public function create(): string{

        return "Hallo saya adalah bukti dari create dalam Profil. ";
    }

    public function edit($nama, $nim): string{
        return "Halo, nama saya adalah $nama dengan nim $nim";
    }
}
