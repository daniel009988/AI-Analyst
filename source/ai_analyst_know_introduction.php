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
						<h4>Introduction to Artificial Intelligence</h4>
					</div> 

					<h3>The Machines Wise Up</h3>

				<h4>The Development of AI Technology</h4>
				<p>Hollywood shaped how we picture Artificial Intelligence: Anthropomorphic robots like C-3PO, the Terminator or RoboCop are the image we construct when we think of artificially created intelligence, human behavior and emotional reactions - or the imitation thereof - included. In today’s world these technologies come to life in the shape of entertainment and search as- sistants like Siri, Google Home and Amazon Alexa.</p>
				<p>Over the last five years AI has emerged as a source for hundreds of products and services that will change life at work, home and leisure worldwide. The term AI has become a marketing message, as businesses aim to incorporate AI in all manner of products from consumer to industrial in mass market product advertising: “Our AI is better than their AI!”. Although consumers are becoming familiar with the technology, applications of AI are present in many aspects of life with neither the consumer’s awareness nor consent.</p>
				<p>In the past, the approach of AI was to provide intelligent prediction tools for better decision-making by using data that entities already generate. Today, Artificial Intelligence is a broad term that encompasses many diverse technologies and sub-technologies, the most interesting and promising technologies being Machine Learning and its subset Deep Learning, Natural Language Processing, and Autonomous Robots.</p>

				<h4>The Development of AI Technology</h4>
				<p>AI needs Big Data to start learning processes. A report by the McKinsey Global Institute states that “billions of gigabytes every day, [are] collected by networked devices rang- ing from web browsers to turbine sensors.” Industrial machinery is increasingly being directly connected to the Internet. IT network specialist Cisco reports that “Over the next five years, global IP networks will support up to 10 billion new devices and connections, increasing from 16.3 billion in 2015 to 26.3 billion by 2020.” These connections will be subject to AI driven systems.</p>

				<h4>The Technology of Technologies</h4>
				<p>The combination of Big Data and AI is a technology that already directly affects business models and the governments that regulate them. Business opportunities from AI promise to lower service and worker costs, provide better quality and consistency for products and services, and improve services in many fields such as education and medical treatment. The report estimated that “about half of all the activities people are paid to do in the world’s workforce could potentially be automated by adapting currently demonstrated technologies... almost $15 trillion in wages.” AI has the potential to double annual economic growth rates of developed countries by 2035.</p>

				<h4>Growth in AI Investment and Acquisitions</h4>
				<p>Tech industry giants like Apple, Baidu, Google, IBM, Intel, Salesforce and Yahoo have been making large direct investments in their own AI projects and are acquiring new AI startups and talent. Traditional industrials such as Ford, GE and Samsung are also pushing into the market. In 2016, players for AI have spent an estimation of between $20 billion and $30 billion with about 10% of that on acquisitions. Venture capitalists are also ramping up their investments in AI startups. More than 550 AI startup ventures received more than $5 billion total investments in 2016, up from $589 million in 2012.</p>

				<h4>Challenges and Risks of AI Technology</h4>
				<p>AI confronts the world, governments, businesses and individuals with new challenges. The infiltration of AI has the potential to greatly improve the lives of millions around the world, but will also have a negative effect on many. AI is also influencing and changing social interactions both in profes- sional and private life and it shows potential to bridge gaps for people of diverse cultures in new ways.</p>
				<p>The job market is undergoing significant changes, and the recently popu- lar coal mining industry illustrates how the reality of the next generation will look like. Human workers will monitor and control the work off their avatar in the mine. Arguably, Artificial Intelligence has the potential to fundamentally change society comparable to the agricultural and industrial revolutions of past millennia. Technology and science leaders such as Elon Musk, Bill Gates and Stephen Hawking have sounded warnings about the disruptions to society such as loss of jobs and entire occupations, and other ethical and social changes.</p>
				<p>Existential problems emerge, as presented by Artificial General Intelligence (AI that performs at human levels), and Artificial Super Intelligence (AI that surpasses humans) who might decide humans are a obsolete. For example, what happens when the AI coal miner begins to reflect on the necessity of coal? The challenge is to manage this transition and to harness benefits and mitigate problems during the AI Revolution.</p>

				<h3>Milestones in Artificial Intelligence Development</h3>

				<p>The first electrically powered programmable computers were built in the 1940s. In the following decades, the innovative development of hard- and software enabled increasingly sophisticated and complex calculations and user interactions. Developers dreamed of building a “thinking machine” that might imitate human reason, but is only recently that the convergence of technologies enabled researchers to begin to realize that dream. IBM introduced one of the first computers in 1953 and the IBM name remained synonymous with the industry for years. Its decline started in the 1980s with the rise of Apple and Asian hardware competitors.</p>
				<p>Now AI has entered a new phase of accelerated growth, driven by three factors:
				<li>major advances in computing power
				<li>distributed computer processing capabilities through worldwide networks of computers
				<li>the resulting ability to collect, store and save enormous amounts of data (Big Data)</p>	

				<h4>Progression of Artificial Intelligence</h4>
				<p>Author Tim Urban gives a clear explanation of the progression of AI devel- opments in his essay “The AI Revolution: The Road to Superintelligence”. He illustrates and analyzes the commonly accepted stages of advances in AI technology: Narrow AI solves a narrowly defined task with a degree of perceived intel- ligence. Current AI applications like Siri and Alexa, as well as game playing computers and intelligent industrial robots are forms of Narrow AI. Artificial General Intelligence (AGI) would be able to perform with aver- age human intelligence. In popular culture, characters like the Terminator and 3-CPO are examples that approach AGI. Artificial Super Intelligence (ASI) would exceed the capabilities of any human being. The consequences of the emergence of ASI - known as the “Singularity” - might only be imagined in science fiction.</p>

				<h4>Big Data Enters the Stage</h4>
				<p>Smartphone devices have infiltrated every aspect of our private and pro- fessional life and have rapidly changed the way we communicate with our expanding network of contacts. Each device is a data vacuum collecting our communication content, shopping habits and political persuasions, tallying purchases and personal interests. Individual users are only a fraction of the data sources that include business IT systems, sensors and other sources that feed the “Big Data” explosion.</p>

				<h4>Human vs. Machine</h4>
				<p>A study by IDC predicts that the “the digital universe will grow by a factor of 10 – from 4.4 trillion gigabytes to 44 trillion” from 2013 to 2020, more than doubling every two years. In addition, IDC demonstrates that the balance between emerging and mature economies in the same period will shift from a 60% share of data growth from mature markets to 60% for emerging markets.</p>

				<h4>Autonomous Intelligence</h4>
				<p>In a recent interview in Wired, former Microsoft engineer and now Baidu CEO Qi Lu forecasts that China will be the Big Data giant if only due to its huge population. On a sociocultural level he also states that “most places in the world have much more in common with the tiny homes of the Chinese than the sprawling North A merican McMansions.”</p>

				<h4>Administrative Rights Levels for Artificial Intelligence Solutions: Human vs Machine</h4>
				<p>Augmented Intelligence: AI enhances human abilities to accomplish tasks faster or better. The human makes key decisions, but AI executes the tasks on behalf of the human. The human retains sole decision rights.</p>
				<p>Assisted Intelligence: The human and AI learn from each other. Together they define their respective responsibilities and share their decision rights.</p>
				<p>Autonomous Intelligence: AI provides adaptive and continuous operation and may have decision authority. AI does so once the human hands responsibility to the AI, or once the human affects efficiency negatively.</p>


				

				
			</div>
		</section>
	</div>



		</div>
		<!-- /wrapper -->


		
		

		

		




</body>
</html>