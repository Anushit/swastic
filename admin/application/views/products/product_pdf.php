<?php

$html = '
		<h3>Category List</h3>
		<table border="1" style="width:100%">
			<thead>
				<tr class="headerrow">
					<th>Model</th>
					<th>Name</th>
					<th>Price</th>
					<th>Special Price</th>
					<th>Sort Order</th> 
					<th>Created Date</th>
				</tr>
			</thead>
			<tbody>';

			foreach($all_products as $row):
			$html .= '		
				<tr class="oddrow">
					<td>'.$row['model'].'</td>
					<td>'.$row['name'].'</td>
					<td>'.$row['price'].'</td>
					<td>'.$row['special_price'].'</td>
					<td>'.$row['sort_order'].'</td> 
					<td>'.$row['created_at'].'</td>
				</tr>';
			endforeach;

			$html .=	'</tbody>
			</table>			
		 ';
				
		$mpdf = new mPDF('c');

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Admin - Products List");
		$mpdf->SetAuthor("AYT");
		$mpdf->watermark_font = 'AYT';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');		 
		 

		$mpdf->WriteHTML($html);

		$filename = 'Product_list1';

		ob_clean();

		$mpdf->Output($filename . '.pdf', 'D');

		exit();

?>