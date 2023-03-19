<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['first_name', 'last_name', 'fullname', 'gender', 'email', 'postcode', 'address', 'building_name', 'opinion']);

        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        if($request->input('repair') == 'repair')
        {
            return redirect('/')->withInput();
        }
        
        $contact = $request->only([
            'fullname',
            'gender',
            'email',
            'postcode',
            'address',
            'building_name',
            'opinion']);
        Contact::create($contact);
        return view('thanks');
    }

    public function manage()
    {
        $contacts = Contact::Paginate(10);

        return view('management', compact('contacts'));
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();

        return redirect('/management');
    }

    public function search(Request $request)
    {
        if($request->input('reset') == 'reset')
        {
            return redirect('/management');
        }
        
        $contacts = Contact::select()
            ->NameSearch($request->fullname)
            ->GenderSearch($request->gender)
            ->DateFromSearch($request->created_at_from)
            ->DateToSearch($request->created_at_to)
            ->EmailSearch($request->email)
            ->Paginate(10);
        
        session()->flashInput($request->input());
        return view('management', compact('contacts'));
    }   
}
