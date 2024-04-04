<h2>鉄道路線編集</h2>
<div>
    {{ html()->modelForm($initialParams, 'PUT', "/admin/railway_stations/${railwayStationId}")->open() }}
        <div>
            {{ html()->label('適用開始日')->for('railway-stations-edit-valid-from') }}
            {{ html()->text('valid_from')->id('railway-stations-edit-valid-from') }}
            @error('valid_from')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('鉄道路線ID')->for('railway-stations-edit-railway-route-id') }}
            {{ html()->text('railway_route_id')->id('railway-stations-edit-railway-route-id') }}
            @error('railway_route_id')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('駅名')->for('railway-stations-edit-name') }}
            {{ html()->text('name')->id('railway-stations-edit-name') }}
            @error('name')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->label('駅愛称')->for('railway-stations-edit-nickname') }}
            {{ html()->text('nickname')->id('railway-stations-edit-nickname') }}
            @error('nickname')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->hidden('token')->id('railway-stations-edit-token') }}
            @error('token')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->submit('変更') }}
        </div>
    {{ html()->form()->close() }}
</div>
