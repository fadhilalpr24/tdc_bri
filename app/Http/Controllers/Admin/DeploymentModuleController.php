<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\DeploymentModule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DeploymentModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
        $query = DeploymentModule::query();

        return DataTables::of($query)
            ->addColumn('action', function ($module) {
                return '
                    <a class="block w-full px-2 py-1 mb-1 text-xs text-center text-white transition duration-500 bg-gray-700 border border-gray-700 rounded-md select-none ease hover:bg-gray-800 focus:outline-none focus:shadow-outline"
                        href="' . route('admin.deployment-modules.edit', $module->id) . '">
                        Sunting
                    </a>
                    <form class="block w-full" onsubmit="return confirm(\'Apakah anda yakin?\');" action="' . route('admin.deployment-modules.destroy', $module->id) . '" method="POST">
                        <button class="w-full px-2 py-1 text-xs text-white transition duration-500 bg-red-500 border border-red-500 rounded-md select-none ease hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                        ' . method_field('delete') . csrf_field() . '
                    </form>';
            })
            ->rawColumns(['action'])
            ->make();
    }

    return view('admin.deployment-modules.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.deployment-modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        if (DeploymentModule::where('name', $request->name)->first()) {
            return redirect()->back()->with('error', 'Module already exists.');
        }

        DeploymentModule::create($request->all());

        return redirect()->route('admin.deployment-modules.index')->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeploymentModule $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $deploymentModule = DeploymentModule::find($id);

        return view('admin.deployment-modules.edit', compact('deploymentModule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $module = DeploymentModule::find($id);

        if (!$module) {
            return redirect()->back()->with('error', 'Module not found.');
        }

        // if modul name is changed, check if the new name already exists
        if ($module->name != $request->name) {
            if (DeploymentModule::where('name', $request->name)->first()) {
                return redirect()->back()->with('error', 'Module already exists.');
            }
        }

        $module->update($request->all());

        return redirect()->route('admin.deployment-modules.index')->with('success', 'Module updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $module = DeploymentModule::find($id);

        if (!$module) {
            return redirect()->back()->with('error', 'Module not found.');
        }

        $module->delete();

        return redirect()->route('admin.deployment-modules.index')->with('success', 'Module deleted successfully.');
    }
}