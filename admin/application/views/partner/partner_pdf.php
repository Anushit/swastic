<?php

$html = '
		<h3>Partner List</h3>
		<table border="1" style="width:100%">
			<thead>
				<tr class="headerrow"> 
					<th>Name</th>
					<th>Email</th>
					<th>Mobile</th> 
					<th>Created Date</th>
				</tr>
			</thead>
			<tbody>';

			foreach($all_partners as $row):
			$html .= '		
				<tr class="oddrow"> 
					<td>'.$row['name'].'</td>
					<td>'.$row['email'].'</td>
					<td>'.$row['mobile'].'</td> 
					<td>'.$row['created_at'].'</td>
				</tr>';
			endforeach;

			$html .=	'</tbody>
			</table>			
		 ';
				
		$mpdf = new mPDF('c');

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Admin - Partner List");
		$mpdf->SetAuthor("AYT");
		$mpdf->watermark_font = 'AYT';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');		 
		 

		$mpdf->WriteHTML($html);

		$filename = 'partner_list1';

		ob_clean();

		$mpdf->Output($filename . '.pdf', 'D');

		exit();

?>