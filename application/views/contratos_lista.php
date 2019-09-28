<?php 
	$data['pagina'] = 'pagina2';
	$data['id'] = $sesion['id'];
	$this->load->view('header', $data);
?>
			</div>
		</div>
		<script>
			function VerContrato(id){
				window.location.href = 'contrato_ver?id='+id;
			}

			function Compartir(id){
				var contenido = '<h2>Compartir Contrato</h2>'+
								'</br>'+
								'<div id="txt_mensaje1" style="color:red;"></div>'+
								'<label>Ingrese el correo del invitado a este contrato:</label></br>'+
								'<input type="text" id="txt_correo_invitacion"></br></br>'+
								'<input type="button" id="btn_compartir" onclick="ContratoCompartir('+id+');" value="Compartir">';
				AbrirAlerta(contenido,'auto','auto');
			}

			function ContratoCompartir(id){
				var correo_invitado = jQuery('#txt_correo_invitacion').val();
				if(correo_invitado == '' || validateEmail(correo_invitado) == false){
					jQuery('#txt_mensaje1').html('Ingrese un correo valido.');
				}
				else{
					jQuery('#btn_compartir').val('Espere...');
					jQuery('#btn_compartir').prop('disabled', true);
					jQuery.ajax({
				        url: "../inicio/contrato_compartir",
				        type: 'post',
				        data: {
				            correo_invitado:encode(correo_invitado),
				            contrato_id:id
				        },
				        dataType: 'json',
				        success: function(respuesta) {
				        	jQuery('.div_loader').hide();
				        	switch(parseInt(respuesta.res)){
				        		case 1:
				        			var mensaje = '<div>Se ha compartido el contrato correctamente con <strong>'+respuesta.invitado_nombre+'</strong>.</div>';
				        			break;
				           		case 3:
				        			var mensaje = '<div>El correo ingresado ya está invitado a este contrato.</div>';
				        			break;
				        		default:
				        			var mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
				        			break;
				        	}
				        	AbrirAlerta(mensaje, 'auto', 'auto');
				        },
				        error: function (error){
				            //alert(error);
				        }
				    }); 
				}
			}
		</script>
		<!-- Main -->
		<div id="main-wrapper">
			<div class="container">						
				<!-- Content -->
				<article class="box post" style="height:1200px;">
					<a href="#" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic01.jpg" alt="" /></a>
					<header>
						<h2>Contratos Generados</h2>
						<p>Listado general de contratos generados</p>
					</header>
					<p>
						<?php
							if($contratos_generados['res'] == 1){
					        	$html_contratos = '<table>
						        						<th>No.</th>
						        						<th>Nombre</th>
						        						<th>Fecha de Creacion</th>
						        						<th>Fecha de Modificacion</th>
						        						<th>Categoría</th>
						        						<th>Estado</th>
						        						<th>Operaciones</th>';
						        $i = 1;
					        	foreach ($contratos_generados['contratos'] as $key => $value) {
					        		switch ($value['estado']) {
					        			case '1':
					        				$estado = 'Generado';
					        				break;
					        			case '2':
					        				$estado = 'Revision';
					        				break;
					        			default:
					        				$estado = 'Generado';
					        				break;
					        		}
					        		$html_contratos .= '<tr>
					        								<td>'.$i.'</td>
					        								<td>'.$value['contrato_nombre'].'</td>
					        								<td>'.$value['fecha_creacion'].'</td>
					        								<td>'.$value['fecha_modificacion'].'</td>
					        								<td>'.$value['categoria_nombre'].'</td>
					        								<td>'.$estado.'</td>
					        								<td>
					        									<input type="button" Value="Ver" onclick="VerContrato('.$value['contrato_id'].');">
					        									<input type="button" Value="Compartir" onclick="Compartir('.$value['contrato_id'].');">
					        								</td>
					        							</tr>'; 
					        		$i++;
					        	}
					        	$html_contratos .= '</table>';
					        	echo $html_contratos; 
					        }
					        else{
					        	echo 'No ha generado ningun contrato.';
					        }
						?>		
					</p>
					<header>
						<h2>Contratos Invitados</h2>
						<p>Listado general de contratos invitados</p>
					</header>
					<p>
						<?php
							if($contratos_invitados['res'] == 1){
					        	$html_contratos = '<table>
						        						<th>No.</th>
						        						<th>Nombre</th>
						        						<th>Fecha de Creacion</th>
						        						<th>Fecha de Modificacion</th>
						        						<th>Categoría</th>
						        						<th>Estado</th>
						        						<th>Invitado por</th>
						        						<th>Operaciones</th>';
						        $i = 1;
					        	foreach ($contratos_invitados['contratos'] as $key => $value) {
					        		switch ($value['estado']) {
					        			case '1':
					        				$estado = 'Invitado';
					        				break;
					        			case '2':
					        				$estado = 'Revision';
					        				break;
					        			default:
					        				$estado = 'Invitado';
					        				break;
					        		}
					        		$html_contratos .= '<tr>
					        								<td>'.$i.'</td>
					        								<td>'.$value['contrato_nombre'].'</td>
					        								<td>'.$value['fecha_creacion'].'</td>
					        								<td>'.$value['fecha_modificacion'].'</td>
					        								<td>'.$value['categoria_nombre'].'</td>
					        								<td>'.$estado.'</td>
					        								<td>'.$value['invitado_por'].'</td>
					        								<td>
					        									<input type="button" Value="Ver" onclick="VerContrato('.$value['contrato_id'].');">
					        								</td>
					        							</tr>'; 
					        		$i++;
					        	}
					        	$html_contratos .= '</table>';
					        	echo $html_contratos; 
					        }
					        else{
					        	echo 'No ha sido invitado a ningun contrato.';
					        }
						?>		
					</p>
				</article>
			</div>
		</div>
<?php $this->load->view('footer'); ?>