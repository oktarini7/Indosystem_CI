<?php

class Model_indosystem2 extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function answer4(){
		$output= '<table>';
		$output.= '<th>event_name</th><th>ticket_class</th><th>ticket_available</th>';
		$query = $this->db->query("SELECT event.event_name, ticket.ticket_class, eventticket.ticket_available FROM event, ticket, eventticket WHERE (eventticket.ticket_price <= ticket.standard_min_price OR eventticket.ticket_price >= ticket.standard_max_price) AND event.event_id = eventticket.event_id AND ticket.ticket_id = eventticket.ticket_id");
		foreach ($query->result_array() as $row){
			$output.= '<tr>';
			$output.= '<td>'.$row['event_name'].'</td>';
			$output.= '<td>'.$row['ticket_class'].'</td>';
			$output.= '<td>'.$row['ticket_available'].'</td>';
			$output.= '</tr>';
		}
		$output.='</table>';
		return $output;
	}

	public function answer5a(){
		$output= '<table>';
		$output.= '<th>event_name</th><th>jumlah_harga_total_penjualan</th>';
		$query = $this->db->query("SELECT event.event_name, SUM((attendee.num_of_person_going+1)*eventticket.ticket_price) AS jumlah_harga_total_penjualan FROM event, attendee, eventticket WHERE payment_status='PAID' AND eventticket.ticket_id= attendee.ticket_id AND eventticket.event_id= attendee.event_id AND event.event_id= attendee.event_id GROUP BY event.event_id");
		foreach ($query->result_array() as $row){
			$output.= '<tr>';
			$output.= '<td>'.$row['event_name'].'</td>';
			$output.= '<td>'.$row['jumlah_harga_total_penjualan'].'</td>';
			$output.= '</tr>';
		}
		$output.='</table>';
		return $output;
	}

	public function answer5b(){
		$output= '<table>';
		$output.= '<th>event_name</th><th>jumlah_harga_total_penjualan</th>';
		$query = $this->db->query("SELECT event.event_name, SUM((attendee.num_of_person_going+1)*eventticket.ticket_price) AS jumlah_harga_total_penjualan FROM event, attendee, eventticket WHERE payment_status='PAID' AND CAST(attendee.payment_date AS DATE)=CURDATE() AND eventticket.ticket_id= attendee.ticket_id AND eventticket.event_id= attendee.event_id AND event.event_id= attendee.event_id GROUP BY event.event_id");
		foreach ($query->result_array() as $row){
			$output.= '<tr>';
			$output.= '<td>'.$row['event_name'].'</td>';
			$output.= '<td>'.$row['jumlah_harga_total_penjualan'].'</td>';
			$output.= '</tr>';
		}
		$output.='</table>';
		return $output;
	}

	public function answer6(){
		$output= '<table>';
		$output.= '<th>event_name</th><th>ticket_class</th>';
		$query = $this->db->query("SELECT 'One Direction' as event_name, ticket_class FROM ticket WHERE NOT EXISTS (SELECT ticket_id FROM eventticket WHERE eventticket.ticket_id =ticket.ticket_id AND event_id='1') UNION SELECT 'Slank' as event_name, ticket_class FROM ticket WHERE NOT EXISTS (SELECT ticket_id FROM eventticket WHERE eventticket.ticket_id =ticket.ticket_id AND event_id='2') UNION SELECT 'Beyonce' as event_name, ticket_class FROM ticket WHERE NOT EXISTS (SELECT ticket_id FROM eventticket WHERE eventticket.ticket_id =ticket.ticket_id AND event_id='3') UNION SELECT 'Iwan Fals' as event_name, ticket_class FROM ticket WHERE NOT EXISTS (SELECT ticket_id FROM eventticket WHERE eventticket.ticket_id =ticket.ticket_id AND event_id='4')");
		foreach ($query->result_array() as $row){
			$output.= '<tr>';
			$output.= '<td>'.$row['event_name'].'</td>';
			$output.= '<td>'.$row['ticket_class'].'</td>';
			$output.= '</tr>';
		}
		$output.='</table>';
		return $output;
	}

	public function answer7a(){
		$output= '<table>';
		$output.= '<th>event_name</th><th>ticket_class</th><th>total_ticket</th>';
		$query = $this->db->query("SELECT * FROM before_pivot");
		foreach ($query->result_array() as $row){
			$output.= '<tr>';
			$output.= '<td>'.$row['event_name'].'</td>';
			$output.= '<td>'.$row['ticket_class'].'</td>';
			$output.= '<td>'.$row['total_ticket'].'</td>';
			$output.= '</tr>';
		}
		$output.='</table>';
		return $output;
	}

	public function answer7b(){
		$output= '<table>';
		$output.= '<th>event_name</th><th>Festival</th><th>Bronze</th><th>Silver</th><th>Gold</th><th>Platinum</th>';
		$query = $this->db->query('SELECT event_name,
    		coalesce(sum(case when ticket_class = "Festival" then total_ticket end), 0) as "Festival",
    		coalesce(sum(case when ticket_class = "Bronze" then total_ticket end), 0) as "Bronze",
    		coalesce(sum(case when ticket_class = "Silver" then total_ticket end), 0) as "Silver",
			coalesce(sum(case when ticket_class = "Gold" then total_ticket end), 0) as "Gold",
    		coalesce(sum(case when ticket_class = "Platinum" then total_ticket end), 0) as "Platinum"
			from before_pivot group by event_name');
		foreach ($query->result_array() as $row){
			$output.= '<tr>';
			$output.= '<td>'.$row['event_name'].'</td>';
			$output.= '<td>'.$row['Festival'].'</td>';
			$output.= '<td>'.$row['Bronze'].'</td>';
			$output.= '<td>'.$row['Silver'].'</td>';
			$output.= '<td>'.$row['Gold'].'</td>';
			$output.= '<td>'.$row['Platinum'].'</td>';
			$output.= '</tr>';
		}
		$output.='</table>';
		return $output;
	}


}
?>