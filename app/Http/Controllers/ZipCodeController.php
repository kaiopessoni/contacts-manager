<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cagartner\CorreiosConsulta\CorreiosConsulta;

class ZipCodeController extends Controller
{
  /**
   * Display the specified resource.
   *
   * @param string $zipcode
   * @return \Illuminate\Http\Response
   */
  public function get($zipcode) {
    $correios = new CorreiosConsulta();
    $data = $correios->cep($zipcode);

    return Response()->json($data);
  }
}
