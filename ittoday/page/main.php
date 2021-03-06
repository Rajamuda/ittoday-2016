		<script type="text/javascript">
			$(function(){
			if($(window).width() < 768){
			    	$('#logo_t').attr('src','img/logo_putih.png');
			    	$('#logo_t').css('width','50%');
			    	$('#logo_t').css('padding-top','20%');
			    }
			    else{
			   	$('#logo_t').attr('src','img/logo.png');
			   	$('#logo_t').css('width','85%');
			   	$('#logo_t').css('padding-top','0');
			    }

			$(window).bind("resize",function(){
			    console.log($(this).width())
			    if($(this).width() < 768){
			    	$('#logo_t').attr('src','img/logo_putih.png');
			    	$('#logo_t').css('width','50%');
			    	$('#logo_t').css('padding-top','20%');
			    }
			    else{
			   		$('#logo_t').attr('src','img/logo.png');
			   		$('#logo_t').css('width','85%');
			   		$('#logo_t').css('padding-top','0');
			    }
			    
			});
			});
		</script>
		
		<!-- Intro Section -->
		<section id="intro" class="intro-section">
			<div class="container animated">
				<div class="row">
					<div class="col-md-6" style="float:right;">
						<div class="main-text animated" id="logo_i"><img src="img/logo.png" id="logo_t"/><p class="intro-teks">#GrowIT</p></div>
					</div>
					<div class="col-md-6 intro-burung">
						<div class="main-icon animated" id="burung32"><img src="img/burung.32colors.png"></div>
					</div>
				</div>
			</div>
			<div class="down-arrow" id="bawah">
				<a href="#news-main" class="page-scroll"><i class="fa fa-angle-double-down fa-4x" ></i></a>
			</div>    
		</section>

		<!-- NEWS Section -->
		<section id="news-main" class="news-section">
			<div class="container">
				<div class="row" style="margin-left:auto;margin-right:auto">
					<div class="col-lg-12" style="padding-bottom:20px">
						<h1>Berita Terbaru</h1>
					</div>
					<div id="myCarousel" class="carousel slide" data-ride="carousel">

  						<!-- Indicators -->
  						<ol class="carousel-indicators">
    						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    						<li data-target="#myCarousel" data-slide-to="1"></li>
    						<li data-target="#myCarousel" data-slide-to="2"></li>
    						<li data-target="#myCarousel" data-slide-to="3"></li>
  						</ol>

  						<!-- Wrapper for slides -->
  						<div class="carousel-inner" role="listbox">
					
							<?php
								function rip_tags($string) { 
								    
								    // ----- remove HTML TAGs ----- 
								    $string = preg_replace ('/<[^>]*>/', ' ', $string); 
								    
								    // ----- remove control characters ----- 
								    $string = str_replace("\r", '', $string);    // --- replace with empty space
								    $string = str_replace("\n", ' ', $string);   // --- replace with space
								    $string = str_replace("\t", ' ', $string);   // --- replace with space
								    
								    // ----- remove multiple spaces ----- 
								    $string = trim(preg_replace('/ {2,}/', ' ', $string));
								    
								    return $string; 

								}
								
								$opts = array(
    									'http' => array(
      									'user_agent' => 'PHP libxml agent',
    									)
								);

								$context = stream_context_create($opts);					
								libxml_set_streams_context($context);

								$rss = new DOMDocument();
								$rss->load('http://blog.ittoday.web.id/feed/');
						
								$feed = array();
								foreach ($rss->getElementsByTagName('item') as $node) {
									$htmlStr = $node->getElementsByTagName('description')->item(0)->nodeValue;
  									$html = new DOMDocument(); 
  									libxml_use_internal_errors(true);       
  									$html->loadHTML($htmlStr);
  									libxml_use_internal_errors(false);
									//get the first image tag from the description HTML
        							$imgTag = $html->getElementsByTagName('img');
        							$img = ($imgTag->length==0)?'noimg.png':$imgTag->item(0)->getAttribute('src');
									$item = array ( 
										'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
										'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
										'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
										'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
										'image' => $img,
									);
									array_push($feed, $item);
								}
								
								//Menampilkan RSS FEED (maksimal 4)
								$limit = 4;
								for($x=0;$x<$limit;$x++) {
									$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
									$link = $feed[$x]['link'];
									$description = substr(rip_tags($feed[$x]['desc']), 0, 150)." [...]";
									//$image = $feed[$x]['image'];
									$image = preg_replace("/(http:\/\/blog.ittoday.web.id\/wp-content\/uploads\/)([0-9]+\/[0-9]+)\/([a-zA-Z0-9_-]+)-[0-9]+x[0-9]+\.(jpg|png|jpeg|bmp)/","blog/wp-content/uploads/$2/$3.$4", $feed[$x]['image']);
									$date = date('l F d, Y', strtotime($feed[$x]['date']));
									if($x==0) echo '<div class="item active">';
									else echo '<div class="item">';
										echo '<img src="'.$image.'" alt="'.$title.'" style="opacity:0.4;filter:alpha(opacity=40);">';
										echo '<div class="carousel-caption">';
											echo '<h3><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong></h3>';
											echo '<p><small><em>Posted on '.$date.'</em></small></p>';
											echo '<p><small>'.$description.'</small></p>';
											echo '<a href="'.$link.'" title="'.$title.'"><button type="button" class="btn btn-ittoday btn-danger">READ MORE</button></a>';
										echo '</div>';
									echo '</div>';
								}
							?>

							<!-- Left and right controls -->
  							<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    							<span class="sr-only">Previous</span>
  							</a>
  							<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
  	 							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    							<span class="sr-only">Next</span>
  							</a>
  						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- IGDC Section -->
		<section id="igdc-main" class="igdc-section">
			<div class="container animated" id="igdc-start">
				<div class="row">
					<div class="col-lg-12">
						<h1>IPB Game Development Competition</h1>
						<div class="section-icon"><img src="img/igdc/2.png" id="igdc-logo"/></div>
						<p>
							IGDC (IPB Game Development Competition) merupakan ajang kompetisi pembuatan games untuk mahasiswa di Indonesia.
							Kompetisi ini dapat diikuti oleh mahasiswa/pelajar di seluruh Indonesia yang memiliki passion dalam pengembangan aplikasi games. 
						</p>
						<button type="button" class="btn btn-ittoday btn-danger" onclick="window.location.href='igdc'">DETAIL</button>
					</div>
				</div>
			</div>
		</section>

		<!-- ISC Section -->
		<section id="isc-main" class="isc-section">
			<div class="container animated" id="isc-start">
				<div class="row">
					<div class="col-lg-12">
						<h1>IPB Searching Competition</h1>
						<div class="section-icon"><img src="img/isc/3.png"/></div>
						<p>
							IPB Searching Competition merupakan kompetisi menjawab pertanyaan umum melalui bantuan Search Engine. Kompetisi ini bertujuan untuk meningkatkan kemampuan pencarian melalui mesin pencari dan memaksimalkan pengetahuan ataupun informasi yang yang didapat melalui mesin pencari.
													
						</p>
						<button type="button" class="btn btn-ittoday btn-danger" onclick="window.location.href='iscs'">DETAIL</button>
					</div>
				</div>
			</div>
		</section>

		<!-- Agrihack Section -->
		<section id="agrihack-main" class="agrihack-section">
			<div class="container animated" id="agrihack-start">
				<div class="row">
					<div class="col-lg-12">
						<h1>Agrihack - Capture The Flag</h1>
						<div class="section-icon"><img src="img/agrihack/5.png"/></div>
						<p>
							Agrihack merupakan ajang kompetisi di bidang cyber security yaitu "Capture The Flag" untuk SMA/Sederajat dan Diploma di seluruh Indonesia. Peserta akan diminta mencari celah keamanan dari suatu objek untuk mendapatkan "flag".
						</p>
						<button type="button" class="btn btn-ittoday btn-danger" onclick="window.location.href='agrihack'">DETAIL</button>
					</div>
				</div>
			</div>
		</section>

		<!-- Seminar Section -->
		<section id="seminar-main" class="seminar-section">
			<div class="container" id="seminar-start">
				<div class="row">
					<div class="col-lg-12">
						<h1>Seminar Nasional</h1>
						<div class="section-icon animated" id="seminar-logo"><img src="img/seminar/6.png"/></div>
						<p>
							Kegiatan puncak dari IT Today 2016 yang terdiri dari Seminar dan Showcase IGDC. 
							Seminar bertemakan "Grow Indonesia's Future With Technology".
						</p>
						<p>
							Showcase IGDC dapat dihadiri oleh mahasiswa se-IPB, mahasiswa seluruh Indonesia, dan masyarakat sekitar kampus IPB 
							gratis tanpa pendaftaran.
						</p>
						<button type="button" class="btn btn-ittoday btn-danger" onclick="window.location.href='seminar'">DETAIL</button>
					</div>
				</div>
			</div>
		</section>

		<!-- Tanah Section -->
		<section id="tanah-main" class="tanah-section" style="display:none">
			<div class="container animated" id="tanah-start">
				<div class="row">
					<div class="col-lg-12">
						<img src="img/logo.png">
						<p style="font-size:2vmax">Grow Indonesia&#39;s Future with Technology</p>
					</div>
				</div>
			</div>
		</section>