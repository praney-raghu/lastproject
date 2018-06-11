<?php

namespace Ssntpl\Neev\Http\Controllers\Language;

use Illuminate\Http\Request;
use Ssntpl\Neev\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Ssntpl\Neev\LanguageLine;
use Ssntpl\Neev\Facades\Neev;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = DB::table('languages')->pluck('language_code','description');
        return view('neev::user.language.index')->with('languages', $languages);
    }

    /**
     * Update a resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function setLanguage(Request $request)
    {
        $locale = $request->lang;
   		
   		if(session()->has('language'))
		{
			session()->forget('language');
		}
        session(['language'=>$locale]);
                   
        return redirect(route('user.home'));
    }

    /**
     * Display a listing of a resource -- Language Translations
     * 
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $groups = DB::table('language_lines')->where('owner_id', Neev::organisation()->getKey())->distinct()->pluck('group');
        $languages = DB::table('languages')->pluck('language_code', 'description');
        $keys = NULL;

        return view('neev::admin.translation.index')->with(['groups' => $groups, 'languages' => $languages,'keys' => $keys]);
    }

    /**
     * Display a listing of a resource -- Groups with Language Translations
     * 
     * @return \Illuminate\Http\Response
     */
    public function getGroupTranslations(Request $request)
    {
        $group = $request->group_selected;
        $keys = DB::table('language_lines')->where(['group'=>$group,'owner_id'=> Neev::organisation()->getKey()])->pluck('key');
        
        $groups = DB::table('language_lines')->where('owner_id', Neev::organisation()->getKey())->distinct()->pluck('group');
        $languages = DB::table('languages')->pluck('language_code', 'description');

        // Getting translation array for each key of a group
        foreach($keys as $key => $value)
        {
            $key_translations[$value] = DB::table('language_lines')->where(['key' => $value, 'owner_id' => Neev::organisation()->getKey()])->pluck('text')->toArray();
        }

        // Getting translations for each language for a key
        foreach($key_translations as $key => $translations)
        {
            $values[$key] = json_decode($translations[0]);
        }
        //dd($values['accepted']->es);
        return view('neev::admin.translation.index')->with(['groups' => $groups, 'languages' => $languages, 'keys' => $keys, 'values' => $values]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function set(Request $request)
    {
        $request->validate([
            'group' => 'required',
            'key' => 'required',
            'translation_en' => 'required',
        ]);
        
        // Getting list of languages from Database.
        $languages = DB::table('languages')->pluck('language_code', 'description');
        
        // Getting new translations from user.
        foreach ($languages as $description => $code) {
            $keys[] = $code;
            $translation_values[] = $request['translation_' . $code];
        }

        $translations = array_combine($keys, $translation_values);

        // Creating model for setting up translations in Database.
        LanguageLine::create([
            'owner_id' => Neev::organisation()->getKey(),
            'group' => $request->group,
            'key' => $request->key,
            'text' => $translations,
        ]);

        return redirect(route('admin.translation.index'));
    }

    /**
     * Update the specified resource in storage
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $key = $request->pk;
        $arr = preg_split('~_(?=[^_]*$)~', $key);
        $updatedTranslation = $request->value;
        
        $translations = DB::table('language_lines')->where(['key' => $arr[0], 'owner_id' => Neev::organisation()->getKey()])->pluck('text');
        
        /*
        The code below is for editing json column in DB. If you use MySQL >5.7, then this code can be modified
        to directly work on json columns as given in example.
        Example: 
            DB::table('language_lines')
            ->where('key', 'failed')
            ->update(['text->en' => 'These credentials do not match our records.']);
         */
        foreach (json_decode($translations[0]) as $key => $value) {
            if($key === $arr[1])
            {
                $trans = json_decode($translations[0],true);
                $trans[$key] = $updatedTranslation;
                $translations[0] = json_encode($trans);        
            }
        }
        
        LanguageLine::where(['key' => $arr[0], 'owner_id' => Neev::organisation()->getKey() ])
            ->update(['text' => $translations[0]]);

        Artisan::call('cache:clear');
                
        return 1;
    }
    
}
