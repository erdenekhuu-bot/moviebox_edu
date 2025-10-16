<x-layouts.app :title="'Movies'">

    <form action="/">
        @csrf

        <flux:field>
            <flux:label>Movie name</flux:label>
            <flux:description>About movie title or name</flux:description>
            <flux:input name="name"/>
            <flux:error name="username" />
        </flux:field>
    </form>
</x-layouts.app>
