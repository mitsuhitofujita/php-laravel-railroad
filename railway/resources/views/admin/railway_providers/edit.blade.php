<h2>鉄道会社編集</h2>
<div>
    {{ html()->modelForm($initialValues, 'PUT', "/admin/railway_providers/${railwayProviderId}")->open() }}
        <div>
            {{ html()->label('適用開始日')->for('railway-providers-edit-valid-from') }}
            {{ html()->text('valid_from')->id('railway-providers-edit-valid-from') }}
            @error('valid_from')
                {{ html()->span($message) }}
            @enderror
        </div>
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
            {{ html()->submit('変更') }}
        </div>
    {{ html()->form()->close() }}
</div>
