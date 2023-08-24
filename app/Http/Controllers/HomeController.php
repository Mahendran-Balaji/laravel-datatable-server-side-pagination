<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct(Blog $blogDetails){
        $this->blogDetails = $blogDetails;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function getScrappedData(Request $request){
        $query = $this->blogDetails;
        //For Search
        if($request->sSearch!='')
        {
            $keyword = $request->sSearch;
            $query = $query->when($keyword!='', 
            function($q) use($keyword){
                return $q->where('user_id','like','%'.$keyword.'%')
                    ->orwhere('slug','like','%'.$keyword.'%')
                    ->orwhere('keywords','like','%'.$keyword.'%')
                    ->orwhere('title','like','%'.$keyword.'%')
                    ->orwhere('description','like','%'.$keyword.'%')
                    ->orwhere('content','like','%'.$keyword.'%');
            });
        }
      
        $results = $query->get();
        $totalCount = $this->blogDetails->get();
        
        //Sorting
        $columnIndex = $request['iSortCol_0'];
        $order = $request['sSortDir_0'];
        $columns = array(
            0 => 'user_id',
            1 => 'slug',
            2 => 'keywords',
            3 => 'title',
            4 => 'description',
            5 => 'content',
         );
        $columnName = $columns[$columnIndex];
        $limit = $request->iDisplayLength;
        $offset = $request->iDisplayStart;

        $query = $query->when(($limit != '-1' && isset($offset)),
            function ($q) use ($limit, $offset) {
                return $q->offset($offset)->limit($limit);
            });

        $results = $query->orderBy($columnName, $order)->get();
        $column = array();
        $data = array();
        foreach ($results as $list) {
            $col['user_id'] = isset($list->user_id) ? $list->user_id : "NA";
            $col['slug'] = isset($list->slug) ? $list->slug : "NA";
            $col['keywords'] = isset($list->keywords) ? $list->keywords : "NA";
            $col['title'] = isset($list->title) ? $list->title : "NA";
            $col['description'] = isset($list->description) ? $list->description : "NA";
            $col['content'] = isset($list->content) ? $list->content : "NA";
            array_push($column, $col);
            
        }
        $data['sEcho'] = $request->sEcho;
        $data['aaData'] = $column;
        $data['iTotalRecords'] = count($totalCount);
        $data['iTotalDisplayRecords'] = count($totalCount);
        $data['recordsFiltered'] = count($totalCount);
        return json_encode($data);
    }

  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
