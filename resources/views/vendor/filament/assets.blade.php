
        <!-- Autores - UniGym -->
        <!-- 01 diciembre 2023 -->
        <!-- Nicolás Alonso Suárez - https://github.com/Werffios -->
        <!-- Luis Felipe Pulgar -->


@if (isset($data))
    <script>
        window.filamentData = @js($data)
    </script>
@endif

@foreach ($assets as $asset)
    @if (! $asset->isLoadedOnRequest())
        {{ $asset->getHtml() }}
    @endif
@endforeach

<style>
    :root {
        @foreach ($cssVariables ?? [] as $cssVariableName => $cssVariableValue) --{{ $cssVariableName }}:{{ $cssVariableValue }}; @endforeach
    }
</style>
