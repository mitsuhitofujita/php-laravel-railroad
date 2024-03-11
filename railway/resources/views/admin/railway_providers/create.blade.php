<h2>railway create</h2>
<div>
    {{ html()->modelForm($initialParams, 'POST', '/admin/railway_providers/store')->open() }}
        <div>
            {{ html()->label('鉄道会社名')->for('railway-providers-create-name') }}
            {{ html()->text('name')->id('railway-providers-create-name') }}
            @error('name')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->hidden('token')->id('railway-providers-create-token') }}
            @error('token')
                {{ html()->span($message) }}
            @enderror
        </div>
        <div>
            {{ html()->submit('新規追加') }}
        </div>
    {{ html()->form()->close() }}
</div>
