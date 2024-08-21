<x-layout>
    <h1>Households</h1>

    <h2>Yours</h2>
    <ul>
        @foreach ($userHouseholds as $uh)
            <li>
                {{ $uh->name }}
            </li>
        @endforeach
    </ul>

    <hr>

    <h2>Others</h2>
    <ul>
        @foreach ($otherHouseholds as $oh)
            <li>
                {{ $oh->name }}
            </li>
        @endforeach
    </ul>
</x-layout>
