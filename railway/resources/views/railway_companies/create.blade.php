<h2>railway create</h2>
<div>
    {{ html()->form('POST', '/railway_companies/store')->open() }}
        {{ html()->label('鉄道会社名')->for('railway-companies-store-name') }}
        {{ html()->text('name')->id('railway-companies-store-name') }}
        @error('name')
            <li>{{$message}}</li>
        @enderror
        {{ html()->submit('新規追加') }}
    {{ html()->form()->close() }}
</div>
