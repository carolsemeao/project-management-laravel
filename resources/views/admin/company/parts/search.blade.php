<form action=""> <!-- TODO: Functionality -->
    <div class="join w-full">
        <label class="input join-item w-full">
            <input type="text" placeholder="{{ __(key: 'Search customers by name, company or email...') }}" />
        </label>
        <button class="btn btn-neutral join-item">
            <i class="icon icon-search"></i>
            {{ __('Search') }}
        </button>
    </div>
</form>