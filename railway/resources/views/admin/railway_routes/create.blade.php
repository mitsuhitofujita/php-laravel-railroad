<h2>鉄道路線追加</h2>
<div>
    {{ html()->modelForm($initialParams, 'POST', '/admin/railway_routes')->open() }}
        <div>
            {{ html()->label('鉄道会社ID')->for('railway-routes-create-railway-provider-id') }}
            {{ html()->text('railwayProviderId')->id('railway-routes-create-railway-provider-id') }}
            @error('railwayProviderId')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('路線名')->for('railway-routes-create-name') }}
            {{ html()->text('name')->id('railway-routes-create-name') }}
            @error('name')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->hidden('token')->id('railway-routes-create-token') }}
            @error('token')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->submit('新規追加') }}
        </div>
    {{ html()->form()->close() }}
</div>
