<div class="flex justify-center align-items-center">
    {!! QrCode::size(350)->generate($record->code) !!}
</div>
