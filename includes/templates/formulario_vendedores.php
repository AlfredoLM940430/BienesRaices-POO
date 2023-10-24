
<fieldset>

    <legend>Inofrmacion General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre vendedor(a)" value="<?php echo s($vendedor->nombre); ?>">

    <label for="precio">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido vendedor(a)" value="<?php echo s($vendedor->apellido); ?>">

    <label for="telefono">telefono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Telefono vendedor(a)" value="<?php echo s($vendedor->telefono); ?>">

</fieldset>