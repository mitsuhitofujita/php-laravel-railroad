<h2>鉄道路線追加</h2>
<div>
    {{ html()->modelForm($initialParams, 'POST', '/admin/railway_routes')->open() }}
        <div>
            {{ html()->label('適用開始日')->for('railway-routes-create-valid-from') }}
            {{ html()->text('valid_from')->id('railway-routes-create-valid-from') }}
            @error('valid_from')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('鉄道会社ID')->for('railway-routes-create-railway-provider-id') }}
            {{ html()->text('railway_provider_id')->id('railway-routes-create-railway-provider-id') }}
            @error('railway_provider_id')
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
