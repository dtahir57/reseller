<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Http\Requests\CityRequest;
use DB;
use Session;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = DB::table('cities')->paginate(10);
        return view('admin.city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.city.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $city = new City;
        $city->city_name = $request->city_name;
        $city->save();
        Session::flash('created', 'New City Added Successfully!');
        return redirect()->route('admin.city.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::find($id);
        return view('admin.city.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, $id)
    {
        $city = City::find($id);
        $city->city_name = $request->city_name;
        $city->update();
        Session::flash('updated', 'City Name Updated Successfully!');
        return redirect()->route('admin.city.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();
        Session::flash('deleted', 'City Deleted Successfully!');
        return redirect()->route('admin.city.index');
    }
}
