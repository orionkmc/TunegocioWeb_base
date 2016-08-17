<div class="panel panel-info" style="width: 99%; margin-top: 20px;">
    <div class="panel-heading">
        <form action="admin.php?page=contacts" method="post">
            <span class="panel-title"> Todos los contactos </span>
            <input type="submit" class="btn btn-default btn-xs" name="export_contact" value="Importar contactos">
        </form>
        <span style="float: right; margin-top: -19px;"></span>
    </div>
    <div class="panel-body">

        <script type="text/javascript" language="javascript" class="init">
            var $j = jQuery.noConflict();
            $j(document).ready(function() {
                $j('#contacts').DataTable( {
                    "pagingType": "full_numbers"
                } );
            } );
        </script>
        
        <table id="contacts" class="table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Email</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Email</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($contacts as $key): ?>
                <tr>
                    <td> <a href="<?= admin_url( 'admin.php?page=contacts&id='. $key->id) ?>"><?= $key->name?></a></td>
                    <td><?= $key->phone ?></td>
                    <td><?= $key->email ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>
</div>