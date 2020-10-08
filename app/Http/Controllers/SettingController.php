<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Site;

class SettingController extends Controller
{

	public function save(Request $request)
	{
		$request->validate([
			'name' => 'required|string',
			'address' => 'required|string'
		]);

		Site::first()->update($request->all());

		return back()->with('success', 'Success Save Setting');
	}

}
