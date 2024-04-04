<h2>鉄道駅追加</h2>
<div>
    {{ html()->modelForm($initialParams, 'POST', '/admin/railway_stations')->open() }}
        <div>
            {{ html()->label('適用開始日')->for('railway-stations-create-valid-from') }}
            {{ html()->text('valid_from')->id('railway-stations-create-valid-from') }}
            @error('valid_from')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('鉄道路線ID')->for('railway-stations-create-railway-route-id') }}
            {{ html()->text('railway_route_id')->id('railway-stations-create-railway-route-id') }}
            @error('railway_route_id')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('駅名')->for('railway-stations-create-name') }}
            {{ html()->text('name')->id('railway-stations-create-name') }}
            @error('name')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('駅愛称')->for('railway-stations-create-nickname') }}
            {{ html()->text('nickname')->id('railway-stations-create-nickname') }}
            @error('nickname')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->hidden('token')->id('railway-stations-create-token') }}
            @error('token')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->submit('新規追加') }}
        </div>
    {{ html()->form()->close() }}
</div>
