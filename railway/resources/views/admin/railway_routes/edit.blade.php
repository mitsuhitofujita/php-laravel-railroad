<h2>鉄道路線編集</h2>
<div>
    {{ html()->modelForm($initialParams, 'PUT', "/admin/railway_routes/${id}")->open() }}
        <div>
            {{ html()->label('鉄道会社ID')->for('railway-routes-edit-railway-provider-id') }}
            {{ html()->text('railwayProviderId')->id('railway-routes-edit-railway-provider-id') }}
            @error('railwayProviderId')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('路線名')->for('railway-providers-edit-name') }}
            {{ html()->text('name')->id('railway-providers-edit-name') }}
            @error('name')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->hidden('token')->id('railway-providers-edit-token') }}
            @error('token')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->submit('変更') }}
        </div>
    {{ html()->form()->close() }}
</div>
