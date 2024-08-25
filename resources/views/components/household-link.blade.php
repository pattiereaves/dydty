@props(['household'])

<a href="{{ url('/households/'.$household->id) }}">{{ $household->name }}</a>
