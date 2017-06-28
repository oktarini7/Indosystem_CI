<hr>
<br />

<ol>
<li>Ada 2 hal yang bisa diimprove:<br />
A) Untuk table eventticket bisa dipecah menjadi 4 table untuk setiap event_id.<br />
B) Untuk table attendee, juga bisa dipecah menjadi 4 table (1 table untuk setiap event_id). Sehingga jika terdapat orang yang menghadiri 2 event berbeda, tidak akan terdapat 2 attendee_id untuk 1 orang yang sama dalam 1 table.</li><br />
<li>Table event= event_id, table ticket= ticket_id, table eventticket=event_id dan ticket_id, table attendee= attendee_id</li><br />
<li>Table event= event_name, table ticket= ticket_class, table eventticket=ticket_price, table attendee= event_id, ticket_id</li><br />
<li>SELECT event.event_name, ticket.ticket_class, eventticket.ticket_available FROM event, ticket, eventticket WHERE (eventticket.ticket_price <= ticket.standard_min_price OR eventticket.ticket_price >= ticket.standard_max_price) AND event.event_id = eventticket.event_id AND ticket.ticket_id = eventticket.ticket_id;<br /><br />
	Hasilnya adalah sbb: <br />
	<?php echo $answer4; ?></li><br />
<li>A) Jika per hari ini yang dimaksudkan adalah sampai hari ini:<br />
	SELECT event.event_name, SUM((attendee.num_of_person_going+1)*eventticket.ticket_price) AS jumlah_harga_total_penjualan FROM event, attendee, eventticket WHERE payment_status='PAID' AND eventticket.ticket_id= attendee.ticket_id AND eventticket.event_id= attendee.event_id AND event.event_id= attendee.event_id GROUP BY event.event_id;<br /><br />
	Hasilnya adalah sbb: <br />
	<?php echo $answer5a; ?><br /><br />
	B) Jika per hari ini yang dimaksudkan adalah hanya hari ini:<br />
	SELECT event.event_name, SUM((attendee.num_of_person_going+1)*eventticket.ticket_price) AS jumlah_harga_total_penjualan FROM event, attendee, eventticket WHERE payment_status='PAID' AND CAST(attendee.payment_date AS DATE)=CURDATE() AND eventticket.ticket_id= attendee.ticket_id AND eventticket.event_id= attendee.event_id AND event.event_id= attendee.event_id GROUP BY event.event_id;<br /><br />
	Hasilnya adalah kosong untuk kasus ini <br />
	<?php echo $answer5b; ?></li><br />
<li>SELECT 'One Direction' as event_name, ticket_class FROM ticket WHERE NOT EXISTS (SELECT ticket_id FROM eventticket WHERE eventticket.ticket_id =ticket.ticket_id AND event_id='1') UNION SELECT 'Slank' as event_name, ticket_class FROM ticket WHERE NOT EXISTS (SELECT ticket_id FROM eventticket WHERE eventticket.ticket_id =ticket.ticket_id AND event_id='2') UNION SELECT 'Beyonce' as event_name, ticket_class FROM ticket WHERE NOT EXISTS (SELECT ticket_id FROM eventticket WHERE eventticket.ticket_id =ticket.ticket_id AND event_id='3') UNION SELECT 'Iwan Fals' as event_name, ticket_class FROM ticket WHERE NOT EXISTS (SELECT ticket_id FROM eventticket WHERE eventticket.ticket_id =ticket.ticket_id AND event_id='4');<br /><br />
	Hasilnya adalah sbb: <br />
	<?php echo $answer6; ?></li><br />
<li>Ada 2 steps:<br />
	A) Membuat tabel yang memuat 3 kolom: event_name, ticket_class, total_ticket<br />
	CREATE VIEW before_pivot AS (SELECT event.event_name, ticket.ticket_class, SUM(num_of_person_going+1) AS total_ticket FROM attendee, ticket, event WHERE event.event_id = attendee.event_id AND ticket.ticket_id= attendee.ticket_id GROUP BY attendee.event_id, attendee.ticket_id); <br /><br />
	Hasilnya adalah sbb: <br />
	<?php echo $answer7a; ?><br /><br />
	B) Membuat pivot table dari table 1 menjadi seperti yang diminta(cara pivot dengan sql saya ambil dari stackoverflow)<br />
	SELECT event_name,
    coalesce(sum(case when ticket_class = "Festival" then total_ticket end), 0) as "Festival",
    coalesce(sum(case when ticket_class = "Bronze" then total_ticket end), 0) as "Bronze",
    coalesce(sum(case when ticket_class = "Silver" then total_ticket end), 0) as "Silver",
	coalesce(sum(case when ticket_class = "Gold" then total_ticket end), 0) as "Gold",
    coalesce(sum(case when ticket_class = "Platinum" then total_ticket end), 0) as "Platinum"
	from before_pivot
	group by event_name; <br /><br />
	Hasilnya adalah sbb: <br />
	<?php echo $answer7b; ?><br /><br /></li>
<li>
	A) Update informasi event Iwan False <br />
	UPDATE event SET event_date = DATE_ADD(event_date, INTERVAL 1 YEAR), event_status='NA' WHERE event_id='4';<br /><br />
	B) Update tanggal penjualan tiket <br />
	UPDATE eventticket SET ticket_sell_start = DATE_ADD(ticket_sell_start, INTERVAL 1 YEAR), ticket_sell_end = DATE_ADD(ticket_sell_end, INTERVAL 1 YEAR), ticket_status='NA' WHERE event_id='4'; <br /><br />
	C) Cancel pembayaran tiket <br />
	UPDATE attendee SET payment_status = 'CANCELLED' WHERE event_id='4'; <br /><br />
	D) Set ulang jumlah tiket yang available<br />
	&nbsp;&nbsp; d1. Membuat tabel total penjualan semua tiket berdasarkan event_id dan ticket_id<br />
	&nbsp;&nbsp; CREATE VIEW totalticketperevent_idperticket_id AS (SELECT event_id, ticket_id, SUM(num_of_person_going+1) AS total_ticket FROM attendee GROUP BY event_id, ticket_id); <br />
	&nbsp;&nbsp; d2. Update tiket Iwan Fals<br />
	&nbsp;&nbsp; UPDATE eventticket a
				JOIN totalticketperevent_idperticket_id b
				ON a.event_id = b.event_id
				AND a.ticket_id = b.ticket_id
				SET a.ticket_available = a.ticket_available+b.total_ticket
				WHERE a.event_id = '4';<br />
</li>

