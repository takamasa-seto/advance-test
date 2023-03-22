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
            session()->flush();
            return redirect('/management');
        }

        if ($request->method() == "POST") {
            $fullname = $request->fullname;
            $gender = $request->gender;
            $created_at_from = $request->created_at_from;
            $created_at_to = $request->created_at_to;
            $email = $request->email;
        }
        else {
            $fullname = session('fullname');
            $gender = session('gender');
            $created_at_from = session('created_at_from');
            $created_at_to = session('created_at_to');
            $email = session('email');    
        }
        
        $contacts = Contact::select()
            ->NameSearch($fullname)
            ->GenderSearch($gender)
            ->DateFromSearch($created_at_from)
            ->DateToSearch($created_at_to)
            ->EmailSearch($email)
            ->Paginate(10);
        
        session(['fullname' => $fullname]);
        session(['gender' => $gender]);
        session(['created_at_from' => $created_at_from]);
        session(['created_at_to' => $created_at_to]);
        session(['email' => $email]);
        
        return view('management', compact('contacts'));
    }   
}
