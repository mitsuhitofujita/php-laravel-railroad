<h2>railway create</h2>
<div>
    {{ html()->form('POST', '/railway_providers/store')->open() }}
        {{ html()->label('鉄道会社名')->for('railway-providers-store-name') }}
        {{ html()->text('name')->id('railway-providers-store-name') }}
        @error('name')
            <li>{{$message}}</li>
        @enderror
        {{ html()->submit('新規追加') }}
    {{ html()->form()->close() }}
</div>
