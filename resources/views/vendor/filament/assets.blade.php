
        <!-- Autores - UniGym -->
        <!-- 01 diciembre 2023 -->
        <!-- Nicolás Alonso Suárez - https://github.com/Werffios -->
        <!-- Luis Felipe Pulgar - https://github.com/pipelucho -->


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
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-thumb {
        background-color: rgb(148, 180, 59);
        border-radius: 999px;
    }
    ::-webkit-scrollbar-track {
        background-color: transparent;
    }

</style>
