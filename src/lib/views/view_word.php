<?php

function view_word($word) {
  if (empty_or_null($word)) {
    error(404, 'page not found');
  }

  /** page navigator */
  $start = params('start', 0);

  $userid = auth_is();

  $howto = i18n_text('howto');
  $des = $howto . $word . ', ' . $word . $howto;

  $w = ORM::for_table('t_words')->where('word', $word)->find_one();
  $count = 0;
  if (! $w) {
    $data = array('title' => $word, 'site_des' => $des, 'count' => $count->count);
  } else {
    /**!! be carefull below lines */
    $rawsql = "SELECT SQL_CALC_FOUND_ROWS m.id, m.wid, m.uid, m.how, m.updated, u.name, u.email, u.fakename, w.word, v.vup, v.vote, v.vuid, v.vdown\n"
    . "FROM t_memory m\n"
    . "JOIN t_users u ON m.uid = u.id\n"
    . "JOIN t_words w ON m.wid = w.id\n"
    . "LEFT JOIN (\n"
    . "\n"
    . "SELECT vote, mid, uid as vuid, SUM( vote = 1 ) AS vup, SUM( vote = -1 ) AS vdown\n"
    . "FROM t_vote group by mid\n"
    . ") AS v on v.mid = m.id WHERE m.wid = :wid and m.status = 1 ORDER BY v.vup DESC LIMIT $start, 2\n";

    $sqlres = ORM::for_table('t_memory')->raw_query($rawsql, array('wid'=>$w->id))->find_many();
    $count = ORM::for_table('t_memory')->raw_query('SELECT FOUND_ROWS()')->find_one();

    $data = array('title' => $w->word, 'site_des' => $des, 'data' => $sqlres, 'count' => $count->count, 'guid' => $userid);
  }

  $opts = array(
    'http' => array(
      'method' => 'GET',
      'timeout' => 2,
    )
  );

  $context = stream_context_create($opts);

  /** get translation from open.iciba.com */
  $xml = @file_get_contents("http://dict-co.iciba.com/api/dictionary.php?w=$word&key=089BB767EF9EE35E83D509E79B8EDDB9",
  false, $context);

  if (! $xml) {
    return render('word', $data);
  }

  $xmlIndexData = array();

  $xmlparser = xml_parser_create();
  @xml_parse_into_struct($xmlparser, $xml, $xmldata, $xmlIndexData);
  xml_parser_free($xmlparser);

  if (sizeof($xmlIndexData) <= 2) {
    return render('word', $data);
  }

  if (! array_key_exists('DICT', $xmlIndexData)) {
    /** The jinshan api has changed */
    /** info the admin */
    info('jinshan api changed', 'admin');
    return render('word', $data);
  }

  if (!array_key_exists('PS', $xmlIndexData) || !array_key_exists('ACCEPTATION', $xmlIndexData)
  || !array_key_exists('POS', $xmlIndexData)) {
    return render('word', $data);
  }

  /** retrive the data */
  $ps = array();
  $acceptation = array();
  $pos = array();

  $all = array();

  $ps = $xmlIndexData['PS'];
  $acceptation = $xmlIndexData['ACCEPTATION'];
  $pos = $xmlIndexData['POS'];

  if (count($pos) !== count($acceptation)) {
    return render('word', $data);
  }

  if (sizeof($ps) === 2) {

    $all['ps'] = array(
      'en' => $xmldata[$ps[0]]['value'],
      'us' => $xmldata[$ps[1]]['value'],
    );
  }

  $all['acceptation'] = array();

  for ($i=0; $i < count($pos); $i++) { 
    array_push($all['acceptation'], array(
      'pos' => $xmldata[$pos[$i]]['value'],
      'acc' => $xmldata[$acceptation[$i]]['value'],
    ));
  }

  /** end retrive */

  $data['xml'] = $all;

  render('word', $data);
}
