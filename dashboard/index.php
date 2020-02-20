<div>
		<h1>Ultima orden ejecutada</h1>
		<input class="input_vcontrol"  type="number" min="0" max="100" id="orden_vcontrol" value="<?php echo(get_option('orden_vcontrol')) ?>" name="orden_vcontrol"> 
		<br/>
		<br/>
    <h1>Tabla precios</h1>
    <table class="ace_table"> 
      <tr>
        <th>Tipo de cliente</th>
        <th>Precio 1</th>
        <th>Precio 2</th>
        <th>Precio 3</th>
        <th>Precio 4</th>
        <th>Precio 5</th>
      </tr>
           <tr>
        <td>Mayorista</td>
        <td><input type="checkbox" name="mayorista" value="1"  onclick="mayorista(this)" 
        <?php
         if (get_option('mayorista') == 1){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="mayorista" value="2" onclick="mayorista(this)" <?php
         if (get_option('mayorista') == 2){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="mayorista" value="3" onclick="mayorista(this)" 
          <?php
         if (get_option('mayorista') == 3){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="mayorista" value="4" onclick="mayorista(this)" 
          <?php
         if (get_option('mayorista') == 4){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="mayorista" value="5" onclick="mayorista(this)" 
          <?php
         if (get_option('mayorista') == 5){
          echo "checked='true'";
        }
        ?>></td>
      </tr>
      <tr>
        <td>Minorista</td>
        <td><input type="checkbox" name="minorista" value="1" onclick="minorista(this)" <?php
         if (get_option('minorista') == 1){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="minorista" value="2" onclick="minorista(this)" <?php
         if (get_option('minorista') == 2){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="minorista" value="3" onclick="minorista(this)" 
          <?php
         if (get_option('minorista') == 3){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="minorista" value="4" onclick="minorista(this)" 
          <?php
         if (get_option('minorista') == 4){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="minorista" value="5" onclick="minorista(this)"
          <?php
         if (get_option('minorista') == 5){
          echo "checked='true'";
        }
        ?>></td>
      </tr>
      <tr>
        <td>No inicialiados</td>
        <td><input type="checkbox" name="noInicialiados" value="1" onclick="noInicialiados(this)" 
          <?php
         if (get_option('noInicialiados') == 1){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="noInicialiados" value="2" onclick="noInicialiados(this)"
          <?php
         if (get_option('noInicialiados') == 2){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="noInicialiados" value="3" onclick="noInicialiados(this)"
          <?php
         if (get_option('noInicialiados') == 3){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="noInicialiados" value="4" onclick="noInicialiados(this)"
          <?php
         if (get_option('noInicialiados') == 4){
          echo "checked='true'";
        }
        ?>></td>
        <td><input type="checkbox" name="noInicialiados" value="5" onclick="noInicialiados(this)"
          <?php
         if (get_option('noInicialiados') == 5){
          echo "checked='true'";
        }
        ?>></td>
      </tr>
    </table>
</div>