@extends('auth.layouts.master')

@section('title', 'Contacts')

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-7">
                            <h1>Contacts</h1>
                        </div>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Phone</td>
                                <td><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                            </tr>
                            <tr>
                                <td>Аddress</td>
                                <td>{{ $contact->address }}</td>
                            </tr>
                            <tr>
                                <td>Facebook</td>
                                <td>{{ $contact->facebook }}</td>
                            </tr>
                            <tr>
                                <td>Twitter</td>
                                <td>{{ $contact->twitter }}</td>
                            </tr>
                            <tr>
                                <td>Talk</td>
                                <td>{{ $contact->talk }}</td>
                            </tr>
                            <tr>
                                <td>Blogger</td>
                                <td>{{ $contact->blogger }}</td>
                            </tr>
                            <tr>
                                <td>Youtube</td>
                                <td>{{ $contact->youtube }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{!! $contact->description !!}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <ul>
                                        <li><a class="btn view" href="{{ route('contacts.edit', $contact)
                                            }}"><i class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
