<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Authorizable;
use Inertia\Response;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\SettingRequest;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use Authorizable;


    protected $moduleName = "Settings";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $dataSettingFromDB = [];
        $settingFromDB = Setting::select(['key', 'value'])->get();
        foreach ($settingFromDB as $setting) {
            $dataSettingFromDB[$setting->key] = $setting->value;
        }


        $defaultSettings = config('settings');
        foreach ($defaultSettings as &$group) { //referensi
            // Lakukan perulangan pada $defaultSettings['elements']
            foreach ($group['elements'] as &$element) {
                // Periksa jika 'name' dari elemen saat ini ada di $dataDatabase
                if (array_key_exists($element['name'], $dataSettingFromDB)) {
                    // Perbarui nilai 'value' dengan nilai yang sesuai dari $dataSettingFromDB
                    if ($element['type'] == 'file' && $element['data'] == 'image') {
                        $element['value'] = $dataSettingFromDB[$element['name']] ? URL::route('image', ['path' => $dataSettingFromDB[$element['name']], 'w' => 200, 'h' => 200, 'fit' => 'crop']) : null;
                    } else {
                        $element['value'] = $dataSettingFromDB[$element['name']];
                    }
                }
            }

            // Hapus referensi agar tidak mempengaruhi elemen lain
            unset($grup);
            unset($element);
        }

        // dump($defaultSettings);
        // exit;

        return Inertia::render('Settings/General/GeneralSettings', [
            'module_name' => $this->moduleName,
            'defaultSettings' => $defaultSettings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingRequest $request)
    {

        $settings = $request->except('configurations');
        $websiteLogo = Setting::where('key', 'websiteLogo')->first();

        if ($websiteLogo) {
            if (Storage::disk('public')->exists($websiteLogo->value)) {
                Storage::disk('public')->delete($websiteLogo->value);
            }
        }

        $file = $request->websiteLogo;
        if ($file->isValid()) {
            $fileName = "settings-{$file->getClientOriginalName()}";
            $uploadImage = $request->websiteLogo ? $file->storeAs('settings', $fileName, 'public') : null;
        }

        $settings['websiteLogo'] = $uploadImage;

        $rules = Setting::getValidationRules();
        $validSettings = array_keys($rules);

        foreach ($settings as $key => $val) {
            if (in_array($key, $validSettings)) {
                Setting::add(key: $key, val: $val, type: Setting::getDataType($key));
            }
        }

        return redirect()->route('general.edit')->with('message', [
            'type' => 'success',
            'text' => 'Pengaturan telah disimpan!',
        ]);
    }
}
