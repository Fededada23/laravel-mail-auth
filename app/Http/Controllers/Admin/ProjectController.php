<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Type;
use App\Models\Project;
use App\Models\Technology;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Storage;
use App\Models\Lead;
use App\Mail\ConfirmProject;
use Illuminate\Support\Facades\Mail;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types','technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {   

        $data = $request->validated();
        
        $slug = Project::generateSlug($request->title);

        $data['slug'] = $slug;

        
        
        $newProject = new Project();

        if($request->hasFile('cover_image')){
            $path = Storage::disk('public')->put('cover_image', $request->cover_image);
            $data['cover_image'] = $path;
        }
        
        $newProject->fill($data);
        
        $newProject->save();

        if($request->has('technologies')){
            $newProject->technologies()->attach($request->technologies);
        }

        $new_lead= new Lead();
        $new_lead->title = $data['title'];
        $new_lead->description = $data['description'];
       
        
        $new_lead->save();
        Mail::to('hello@example.com')->send(new ConfirmProject($new_lead));


        

        

        return redirect()->route('admin.projects.index')->with('message', 'Nuovo progetto creato');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Project $project)
    {
        $data = $request->validated();

        $data['slug'] = Project::generateSlug($request->title);

        if($request->hasFile('cover_image')){
            if($project->cover_image){
                Storage::delete($project->cover_image);
            }
            $path = Storage::disk('public')->put('cover_image', $request->cover_image);
            $data['cover_image'] = $path;
        }    
       
        $project->update($data);

        if($request->has('technologies')){
            $project->technologies()->sync($request->technologies);
        }
        else{
            $project->technologies()->sync([]);
        }

        return redirect()->route('admin.projects.index')->with('message', 'Modifica al progetto eseguita');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->technologies()->sync([]);

        $project->delete();

        return redirect()->route('admin.projects.index')->with('message','Il progetto ?? stato eliminato');
    }
}
