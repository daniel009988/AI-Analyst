<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: '.'ai_analyst_login.php'); //not logged in
	}
 //Abfrage der Nutzer ID vom Login
$user_id = $_SESSION['userid'];
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$pf_name = 'SIMULATED PORTFOLIO';

//Requirements für StockChartTools:
require_once '../psmw/shortcode.php';
$templates = json_decode(file_get_contents('../psmw/templates/templates.json'), TRUE);
$env = json_decode(file_get_contents('../psmw/config/env.json'), TRUE);

//startdatechart übergeben? format: YYYY-MM-DD
$start_date = $_GET["startdatechart"];
if ($start_date=='') {$start_date='2018-01-03';}
//$start_date='2018-01-03';
include 'include_menu.php';
?>



	

			<!-- Market -->
			
			<div class="container">
				<div class="container">
					<br>
					<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>Introduction to our Quantitative & Qualitative Scoring Method</h4>
					</div> 

					<p>Our international <a href="team.html">team of scientists and experts</a> is providing qualitative input based on their research and scoring. The AI Market Intelligence Platform provides them with insights in the biggest database of AI companies that are shaping the future of AI. It provides them for example with information about development of patent filings, innovation degree, number and quality of published scientific papers, development of job openings, the overall size and strength of each company's internal AI teams, etc. just to name a few datapoints. They are looking at the AI competence in general, the ethical positioning as well as the market environment from an innovation and expert point of view.</p>
								
					<div class="row">
						<div class="col-md-1" valign="top"></div>
						<div class="col-md-10" valign="top">
							<img class="img-fluid" src="assets/images/scoring_model.png" alt="">
							<img class="img-fluid" src="assets/images/shadow2.png" alt="">
						</div>
						<div class="col-md-1" valign="top"></div>
					</div>
					
					<p>We are screening 11.000+ AI-companies worldwide to find and identify the greatest opportunities in the AI market. Our Intelligence Platform provides us with unparalleled deep level insights into these companies. Our scoring approach is rigorous systematic and utilizes our expert team.</p>	
					
					<h3>Market Environment</h3>
					<h4>Market Environment – Funding Momentum</h4>

					<p> It's calculation orignated from market momentum calculation from financial technical analytics. Market momentum is the ability of a market to sustain an increase or decrease in prices. Market momentum is a function of a price change during a specific period of time versus the trading volume during that period. In other words, high trading volume increases the market momentum of a price change and vice versa.<p>
					<p>The funding momentum expresses the current funding momentum strength in the segment, based on 2-Quarter rolling mean, with the current quarter mean compared to the previous quarter mean:</p>
					<p>The funding momentum is calculated as M = (Ix / Ix-y) * 100
					<p>M = Funding Momentum
					<br>Ix = Current total funding amount (USD) - Quarterly - 2 Quarter rolling mean
					<br>Ix-y = - Previous quarters ago total funding amount (USD) - Quarterly - 2 Quarter rolling mean
					<p> A value of 100 means no momentum (neither increasing or declining), a value below 100 means the momentum is declining and a value above 100 means the momentum is increasing. The scale ranges from (LOW/Ix-y)*100 to (PEAK/Ix-y*100). For example, if the current momentum is at the scales' peak, this means that there hasn't been a stronger momentum since 1.1.2015. If the current momentum is at the scales' low, this means that currently the momentum is the lowest since 1.1.2015.</p>

					<h4>Market Environment - Exit Momentum</h4>

					<p> It's calculation orignated from market momentum calculation from financial technical analytics. Market momentum is the ability of a market to sustain an increase or decrease in prices. Market momentum is a function of a price change during a specific period of time versus the trading volume during that period. In other words, high trading volume increases the market momentum of a price change and vice versa.<p>
					<p>The exit momentum expresses the current exit momentum strength in the segment, based on 2-Quarter rolling mean, with the current quarter mean compared to the previous quarter mean:</p>
					<p>The exit momentum is calculated as M = (Ix / Ix-y) * 100
					<p>M = Exit Momentum
					<br>Ix = Current total exit amount (USD) - Quarterly - 2 Quarter rolling mean
					<br>Ix-y = - Previous quarters ago total exit amount (USD) - Quarterly - 2 Quarter rolling mean
					<p> A value of 100 means no momentum (neither increasing or declining), a value below 100 means the momentum is declining and a value above 100 means the momentum is increasing. The scale ranges from (LOW/Ix-y)*100 to (PEAK/Ix-y*100). For example, if the current momentum is at the scales' peak, this means that there hasn't been a stronger momentum since 1.1.2015. If the current momentum is at the scales' low, this means that currently the momentum is the lowest since 1.1.2015.</p>

					<h4>Market Environment - IPO Momentum</h4>

					<p> It's calculation orignated from market momentum calculation from financial technical analytics. Market momentum is the ability of a market to sustain an increase or decrease in prices. Market momentum is a function of a price change during a specific period of time versus the trading volume during that period. In other words, high trading volume increases the market momentum of a price change and vice versa.<p>
					<p>The IPO momentum expresses the current IPO momentum strength in the segment, based on 2-Quarter rolling mean, with the current quarter mean compared to the previous quarter mean:</p>
					<p>The IPO momentum is calculated as M = (Ix / Ix-y) * 100
					<p>M = IPO Momentum
					<br>Ix = Current total IPO amount raised (USD) - Quarterly - 2 Quarter rolling mean
					<br>Ix-y = - Previous quarters ago total IPO amount raised (USD) - Quarterly - 2 Quarter rolling mean
					<p> A value of 100 means no momentum (neither increasing or declining), a value below 100 means the momentum is declining and a value above 100 means the momentum is increasing. The scale ranges from (LOW/Ix-y)*100 to (PEAK/Ix-y*100). For example, if the current momentum is at the scales' peak, this means that there hasn't been a stronger momentum since 1.1.2015. If the current momentum is at the scales' low, this means that currently the momentum is the lowest since 1.1.2015.</p>

					<h4>Market Environment - Sector Investor Quantity</h4>

					<p>Sector Investor Quantity compares the average number of investors in a company of peers vs. the entire industry. A lower number of peers than the industry means that typically companies in this sector have less investors than the industry average. This is an indication that this sector is proportionally less attractive for investors. A higher number of peers than the industry means that typically companies in this sector have more investors than the industry average. This is an indication that this sector is proportionally more attractive for investors.</p>

					<h4>Market Environment - Sector Investor Quality</h4>

					<p>Investor Quality is evaluated by the number of top investors invested in a specific sector or industry. A top investors is defined as a successful investor with more than 50 exits and is either a venture capital, private equity or investment firm. Acellarator programs, entrepreneurship programs, etc. are excluded as those don't add investor quality necessarily.
					<p> This metric expresses the occurance of top investors in this segment, compared to the occurance of top investors in the entire industry. It provides a good indication if the sector is "hot" for top investors currently. The occurance is the average number of top investors per company in the peer group or in the entire industry.</p>

					<h3>Financial Health</h3>
					<h4>Financial Health - Investor Quality vs. Peers</h4>

					<p>Investor Quality is evaluated by the number of top investors invested in a specific sector or industry. A top investors is defined as a successful investor with more than 50 exits and is either a venture capital, private equity or investment firm. Acellarator programs, entrepreneurship programs, etc. are excluded as those don't add investor quality necessarily.
					<p> This metric compares the investor quality of the company (=number of top investors invested in the company) with the average number of top investors per company in the peer group. A higher number shows that the company was able to attract more top investors.</p>

					<h4>Financial Health - Financing Position vs. Peers</h4>

					<p>This indicator expresses how well the company is funded compared to its peers. The average total amount of funding (USD) of the peers is compared with the company's total amount of funding (USD). This provides a good indication if the company is in a better financial / funding position than it's peers.</p>

					<h4>Financial Health - Financing Position vs. Industry</h4>

					<p>This indicator expresses how well the company is funded compared to the industry. The average total amount of funding (USD) of the industry is compared with the company's total amount of funding (USD). This provides a good indication if the company is in a better financial / funding position than the industry.</p>

					<h4>Financial Health - Burn Rate Score</h4>

					<p>The burn rate score expresses the financial health of the company and vs. its peers, capped at a one year window. The higher the value, the better it is. A burn rate score of 100 means that the company has funds to operate for more than one year without requiring additional funding. A burn rate score of 0 means that the company urgently needs to get additional funding. Ranging from 0 (none) to 100 (best score)</p>

					<h3>Momentum Scores</h3>
					<h4>Momentum Scores - Social Media Momentum</h4>

					<p>This metric expresses the social media momentum of the company versus its peers. The mothly growth rate of the company is compared with the average monthly growth rate if its peers. A higher number indicates that the company has stronger monthly growth than its peers. A lower number indicates that the company has less monthly growth than its peers. Ranging from 0 (none) to 100 (best score)</p>

					<h4>Momentum Scores - Partnership Momentum vs. peers</h4>

					<p>This metric expresses the partnership momentum of the company versus its peers. The mothly growth rate of the company is compared with the average monthly growth rate if its peers. A higher number indicates that the company has stronger monthly growth than its peers. A lower number indicates that the company has less monthly growth than its peers. Ranging from 0 (none) to 100 (best score)</p>
				
					<h4>Momentum Scores - Employment Momentum vs. peers</h4>

					<p>This metric expresses the employment momentum of the company versus its peers. Ranging from 0 (none) to 100 (best score)</p>

					<h4>Momentum Scores - News Momentum vs. Peers</h4>

					<p>This metric expresses the news momentum of the company versus its peers. The mothly growth rate of the company is compared with the average monthly growth rate if its peers. A higher number indicates that the company has stronger monthly growth than its peers. A lower number indicates that the company has less monthly growth than its peers. Ranging from 0 (none) to 100 (best score)</p>

					<h3>AI Scores</h3>
					<h4>AI Scores – AI Sector Score</h4>

					<p>This metric expresses how strong the sector is, from an expert point of view. Has the sector been identified as one of the hottest segments in AI? Is the sector adressing a game changing topic? The AI Sector Score is a qualitative measurement and is defined by our human experts. The higher the AI Sector Score, the stronger is the sector in terms of future growth potential. Ranging from 0 (none) to 100 (best score)</p>

					<h4>AI Scores – AI Focus Score</h4>

					<p>This metric expresses how the company is focused on AI. Is it just a little segment of its competences? Or is it the core of the business? The AI Focus Score is a qualitative measurement and is defined by our human experts. The higher the AI Focus Score, the more focus the company has on AI.</p>

					<h4>AI Scores – AI Growth Potential Score</h4>

					<p>This metric expresses the degree of growth potential by using AI. How big can the AI based revenue grow from there? How saturated is the market already? The AI Growth Potential Score is a qualitative measurement and is definied by our human experts. The decision is made based on analysis of the company's business model, it's products and technologies, its uniqueness, its competitors, etc. The higher the AI Growth Potential Score, the more growth potential has this company. Ranging from 0 (none) to 100 (best score)</p>

					<h4>AI Scores – AI Competence Score</h4>

					<p>The AI Competence Score is a qualitative measurement and is definied by our human experts. The higher the AI Competence Score, the more competence has this company in AI. Ranging from 0 (none) to 100 (best score)
					<p>The AI Competence Score is also for example considering:

					<br> (i) the patent grant ranking of the company, vs. the average of it's peers on a scale from none to the hightest number of patents granted of the peers.
					<br> (ii) the number of identified research papers vs. the average of it‘s peers
					<br> (iii) the number of identified scientists employed vs. the average of it‘s peers
					<br> (iv) the number of published AI code on GitHub&Co vs the average of it‘s peers
					<br> (v) a ranking of used high ranked technology stacks vs the average of it‘s peers</p>




				
			</div>
		</section>
	</div>



		</div>
		<!-- /wrapper -->


		
		

		

		




</body>
</html>