<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vista principal</title>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
   
    <style>
     

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        body {
            
            background-color: #9AF288;
        }   

    </style>
</head>

<body>
    <div class="center">
        <h1>Examen</h1>
        <table class="tb">
            <tr>
                <td>
                    <div>
                        Tiendas:
                    </div>
                    <select id="tienda_id">
                        <option value="0">--Seleccione una tienda--</option>
                        @foreach ($Tiendas as $tienda)
                            <option value="{{ $tienda->id }}">{{ $tienda->Nombre_Tienda }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <img src="{{ asset('img/default-profile.png') }}" alt="Imagen" height="100" id="imagen_tienda">
                </td>
            </tr>
            <tr>
                <td>
                    <div>Empleado:</div>
                    <select id="empleado_id">
                        <option value="">-- Selecciona un empleado --</option>
                    </select>
                </td>
                <td><img src="{{ asset('img/default-placeholder.png') }}" alt="Imagen" height="100"
                        id="imagen_empleado"></td>
                    <td>
                        <div id="producto_id"> </div>
                </td>
            <td>
                    <div id="formulario_id"> </div>
                </td>
            </tr>
        </table>
        <h1>Ventas Realizadas</h1>
        <table class="tb">
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Tienda</th>
                <th>Vendedor</th>
                <th>Producto</th>
                <th>Costo</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
            @php($number = 1)
            @foreach ($ventas as $venta)
                <tr>
                    <td> {{ $number }} @php($number = $number + 1)</td>
                    <td>{{ $venta->Fecha }}</td>
                    <td>{{ $venta->Tienda_Id }}</td>
                    <td>{{ $venta->Usuarios_Id }}</td>
                    <td>{{ $venta->Producto_id }}</td>
                    <td>Costo</td>
                    <td>{{ $venta->Cantidad }}</td>
                    <td>{{ $venta->Total }}</td>
                </tr>
            @endforeach

        </table>
    </div>
    @csrf
</body>
<script>
    $(document).ready(function() {
        $('#tienda_id').change(function() {
            var valtienda = $('#tienda_id').val();
            console.log("Tienda seleccionada: " + valtienda);
            if (valtienda == 0) {
                $('#empleado_id').html(
                    ' <select name="tienda" id="tienda_id"> <option value = "0" > -- Selecciona un empleado --'
                );
                $('#imagen_tienda').attr("src", 'img/default-placeholder.png');
            } else {
                $('#empleado_id').empty();
                $('#empleado_id').load("{{ route('datosEmpleados') }}?id_empleado=" + valtienda)
                    .serialize();


                var url = "/FotoTienda";

                var formData = new FormData();
                formData.append('_token', $('input[name=_token]').val());
                formData.append('id_tienda', valtienda);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function(data) {

                        $("#imagen_tienda").attr("src", "img/" + data);

                    },
                    error: function(e) {
                        console.log(e);
                    }

                });



            }

        });
    });
</script>

</html>
