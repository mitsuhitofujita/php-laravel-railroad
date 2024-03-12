<h2>railway edit</h2>
<div>
    {{ html()->modelForm($initialParams, 'PUT', "/admin/railway_providers/${id}")->open() }}
        <div>
            {{ html()->label('鉄道会社名')->for('railway-providers-edit-name') }}
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
            {{ html()->submit('新規追加') }}
        </div>
    {{ html()->form()->close() }}
</div>
