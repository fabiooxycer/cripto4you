<?php
// include('database.php');
// $pdo = BancoCadastros::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM tbl_usuarios where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['UsuarioID']));
$data = $q->fetch(PDO::FETCH_ASSOC);

$mesReferencia = date('m');
if ($mesReferencia == '01') {
  $mes = 'janeiro';
}
if ($mesReferencia == '02') {
  $mes = 'fevereiro';
}
if ($mesReferencia == '03') {
  $mes = 'março';
}
if ($mesReferencia == '04') {
  $mes = 'abril';
}
if ($mesReferencias == '05') {
  $mes = 'maio';
}
if ($mesReferencia == '06') {
  $mes = 'junho';
}
if ($mesReferencia == '07') {
  $mes = 'julho';
}
if ($mesReferencia == '08') {
  $mes = 'agosto';
}
if ($mesReferencia == '09') {
  $mes = 'setembro';
}
if ($mesReferencia == '10') {
  $mes = 'outubro';
}
if ($mesReferencia == '11') {
  $mes = 'novembro';
}
if ($mesReferencia == '12') {
  $mes = 'dezembro';
}
?>

<style type="text/css">
  <!--
  .style1 {
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
  }

  .style2 {
    font-family: Arial, Helvetica, sans-serif
  }
  -->
</style>
<p align="center" class="style1"> CONTRATO DE INVESTIMENTO EM ALUGUEL DE CAPITAL FINANCEIRO PARA<br>
  REALIZA&Ccedil;&Atilde;O DE OPERA&Ccedil;&Otilde;ES DE DAY TRADING<br>
</p>
<p align="center" class="style2"><strong> TERMO INICIAL DE ADES&Atilde;O INDIVIDUAL</strong><br>
</p>
<p align="justify" class="style2">Pelo presente instrumento particular, as partes abaixo qualificadas, firmam o presente Contrato de Investimento em Aluguel de Capital Financeiro para Realiza&ccedil;&atilde;o de Opera&ccedil;&otilde;es de Day Trading e outras aven&ccedil;as, que se reger&aacute; pelas condi&ccedil;&otilde;es e cl&aacute;usulas a seguir convencionadas:<br>
  DAS PARTES</p>
<p align="justify" class="style2"> Da Contratada: CRIPTO4YOU &ndash; F&Aacute;BIO VIEIRA, pessoa f&iacute;sica, devidamente inscrita no CPF sob n&ordm; 009.940.619-51, estabelecida com sua sede &ndash; matriz, &agrave; Rua Neo Alves Martins, 2814, Maring&aacute;, PR, CEP 87013-060, doravante denominada simplesmente ASSESSORA CONTRATADA.</p>
<p align="justify" class="style2"> Do Contratante: <?php echo $data['nome']; ?>, pessoa jur&iacute;dica / f&iacute;sica, portador do RG n&ordm; <?php echo $data['rg']; ?>, devidamente inscrito no CNPJ / CPF sob n&ordm; <?php echo $data['cpf']; ?>, residente e domiciliado na <?php echo $data['endereco']; ?>, <?php echo $data['numero']; ?>, <?php if ($data['complemento'] != '-') {
                                                                                                                                                                                                                                                                                                                                                        echo $data['complemento']; ?>,<?php } ?> <?php echo $data['bairro']; ?>, <?php echo $data['cidade']; ?>, <?php echo $data['estado']; ?>, <?php echo $data['cep']; ?>, com o endereço de email: <?php echo $data['email']; ?>, doravante simplesmente denominado CONTRATANTE &ndash; CLIENTE INVESTIDOR, firmam &agrave; partir desta data, o presente Instrumento &ndash; Contrato de Investimento em Aluguel de Capital Financeiro para Realiza&ccedil;&atilde;o de Opera&ccedil;&otilde;es de Day Trading e Outras Aven&ccedil;as.<br>
  TERMOS PRELIMINARES DE ADES&Atilde;O</p>
<p align="justify" class="style2">Considerando que a ASSESSORA CONTRATADA, trata-se de pessoa atuante no mercado financeiro oscilante, especializada em gest&atilde;o de risco, atuando com negocia&ccedil;&otilde;es de ativos digitais. O presente Instrumento se reger&aacute; pelos princ&iacute;pios e condi&ccedil;&otilde;es, mediante as cl&aacute;usulas a seguir convencionadas.</p>
<p align="justify" class="style2"><strong>DO OBJETO</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA PRIMEIRA: O presente Instrumento - CONTRATO DE INVESTIMENTO - tem por objeto regular os direitos, obriga&ccedil;&otilde;es e garantia do capital financeiro relativo ao investimento desde que, diretamente relacionados ao aluguel do capital investido pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR, para realiza&ccedil;&atilde;o de opera&ccedil;&otilde;es de DAY TRADING, a fim de que o(a) mesmo(a), tenha seu capital rentabilizado nas condi&ccedil;&otilde;es contratadas.<br>
  <br>
  Par&aacute;grafo Primeiro: Pelo presente Instrumento, a ASSESSORA CONTRATADA, atuar&aacute; prioritariamente nos mercados citados na CL&Aacute;USULA PRIMEIRA, utilizando-se de recursos aportados pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR, para fins de obten&ccedil;&atilde;o de lucros para este, exclusivamente.
</p>
<p align="justify" class="style2"> Par&aacute;grafo Segundo: O CONTRATANTE &ndash; CLIENTE INVESTIDOR anui &agrave; ASSESSORA CONTRATADA, para que esta, se necess&aacute;rio, atue em mercados diversos dos elencados na CL&Aacute;USULA PRIMEIRA, utilizando-se de recursos aportados pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR, para fins de obten&ccedil;&atilde;o de lucros para este, especificamente nos casos em que a expertise da ASSESSORA CONTRATADA, indicar maiores/melhores possibilidades de lucro.</p>
<p align="justify" class="style2"> Par&aacute;grafo Terceiro: O presente Instrumento tem por objeto extensivo, regular os direitos e obriga&ccedil;&otilde;es das partes contratantes, relativamente aos lucros auferidos nas opera&ccedil;&otilde;es de compra e venda de a&ccedil;&otilde;es, op&ccedil;&otilde;es ou contratos futuros, mat&eacute;rias primas, mini d&oacute;lar e outras moedas ou outros ativos que a ASSESSORA CONTRATADA entender vi&aacute;veis ao retorno financeiro garantido neste instrumento.</p>
<p align="justify" class="style2"> Par&aacute;grafo Quarto: A ASSESSORA CONTRATADA, declara-se expert na opera&ccedil;&atilde;o de investimento financeiro nos seus mercados de atua&ccedil;&atilde;o, gerenciando os riscos dos investimentos realizados, sendo de conhecimento do CONTRATANTE &ndash; CLIENTE INVESTIDOR, todos os riscos inerentes &agrave;s opera&ccedil;&otilde;es supras descritas.</p>
<p align="justify" class="style2"> Par&aacute;grafo Quinto: Todos as opera&ccedil;&otilde;es financeiras de DAY TRADING ser&atilde;o realizadas exclusivamente em nome da ASSESSORA CONTRATADA, e ou, em nome de seus s&oacute;cios de forma individual ou conjunta, utilizando-se do sistema de nuvem com informa&ccedil;&otilde;es criptografadas, das quais, somente a ASSESSORA CONTRATADA ter&aacute; irrestrito acesso.</p>
<p align="justify" class="style2">CL&Aacute;USULA SEGUNDA: O CONTRATANTE &ndash; CLIENTE INVESTIDOR, neste ato, adere para todos os fins e efeitos de direito, ao presente CONTRATO DE INVESTIMENTO EM ALUGUEL DE CAPITAL FINANCEIRO PARA REALIZA&Ccedil;&Atilde;O DE OPERA&Ccedil;&Otilde;ES DE DAY TRADING, mediante a sua concord&acirc;ncia nos presentes termos iniciais e ainda, DECLARANDO que:</p>
<p align="justify" class="style2">1) Recebeu uma via original do presente CONTRATO DE INVESTIMENTO EM ALUGUEL DE CAPITAL FINANCEIRO PARA REALIZA&Ccedil;&Atilde;O DE OPERA&Ccedil;&Otilde;ES DE DAY TRADING;</p>
<p align="justify" class="style2">2) Leu, entendeu e compreendeu todas as suas cl&aacute;usulas iniciais e condi&ccedil;&otilde;es de ades&atilde;o, nas quais, constam as regras e par&acirc;metros de atua&ccedil;&atilde;o da D TRADERS INVESTIMENTOS E PARTICIPA&Ccedil;&Otilde;ES LTDA, ora ASSESSORA CONTRATADA;<br>
</p>
<p align="justify" class="style2">3) Confirma expressamente que estas lhes foram perfeitamente esclarecidas, e teve a oportunidade de questionar e esclarecer seu conte&uacute;do e objetivos antes da confirma&ccedil;&atilde;o da ades&atilde;o e, finalmente;</p>
<p align="justify" class="style2">4) Concorda inteira e irrestritamente, aceitando todas as cl&aacute;usulas e condi&ccedil;&otilde;es mencionadas no presente Instrumento.</p>
<p align="justify" class="style2"><strong>DO VALOR DO INVESTIMENTO</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA TERCEIRA: O CONTRATANTE &ndash; CLIENTE INVESTIDOR, DECLARA nesta oportunidade, de<br>
  livre e espont&acirc;nea vontade, a sua ades&atilde;o ao presente CONTRATO DE INVESTIMENTO EM ALUGUEL DE CAPITAL FINANCEIRO PARA REALIZA&Ccedil;&Atilde;O DE OPERA&Ccedil;&Otilde;ES DE DAY TRADING, investindo nesta<br>
  data, o aporte em moeda corrente REAL, mediante a transfer&ecirc;ncia eletr&ocirc;nica para a conta banc&aacute;ria indicada pela ASSESSORA CONTRATADA, &agrave; saber:</p>
<p align="justify" class="style2">Banco: 341 - ITA&Uacute;</p>
<p align="justify" class="style2">Ag&ecirc;ncia N&ordm;: 0113</p>
<p align="justify" class="style2">Conta Corrente: 94428-4<br>
  Titularidade: F&aacute;bio Vieira<br>
  CPF n. 009.940.619-51<br>
  PIX CPF: 00994061951</p>
<p align="justify" class="style2"><br>
  Par&aacute;grafo primeiro: A ASSESSORA CONTRATADA e a CONTRATANTE &ndash; CLIENTE INVESTIDOR s&atilde;o obrigados a guardar, assim na conclus&atilde;o do contrato, como em sua execu&ccedil;&atilde;o, os princ&iacute;pios de probidade e boa-f&eacute; (Art. 422, C&oacute;digo Civil), agindo sempre com lealdade, retid&atilde;o e probidade, durante as negocia&ccedil;&otilde;es preliminares, bem como, durante toda a vig&ecirc;ncia do presente Instrumento, sendo o CONTRATANTE &ndash; CLIENTE INVESTIDOR, integralmente respons&aacute;vel pela origem e proced&ecirc;ncia de valor do aporte investido por ele em todas as opera&ccedil;&otilde;es, de modo que em hip&oacute;tese alguma a ASSESSORA CONTRATADA ou seus s&oacute;cios e representantes legais, ser&atilde;o responsabilizados judicialmente, civil ou criminalmente, caso a origem do recursos financeiros aportados pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR, venha a ser considerada il&iacute;cita, tendo em vista a ASSESSORA CONTRATADA declarar antecipadamente, desconhece - l&aacute;.<br>
  &emsp;<br>
  <strong>DA CAR&Ecirc;NCIA</strong>
</p>
<p align="justify" class="style2">CL&Aacute;USULA QUARTA: Os valores depositados &agrave; t&iacute;tulo de investimento em ALUGUEL DE CAPITAL FINANCEIRO PARA REALIZA&Ccedil;&Atilde;O DE OPERA&Ccedil;&Otilde;ES DE DAY TRADING, ficar&atilde;o aderidos ao prazo carencial de 90 dias, contados da data da integraliza&ccedil;&atilde;o do capital.</p>
<p align="justify" class="style2"> Par&aacute;grafo Primeiro: Ultrapassado o prazo de car&ecirc;ncia descrito no caput desta Cl&aacute;usula, e, sendo do interesse do CONTRATANTE &ndash; CLIENTE INVESTIDOR, o seu levantamento, dever&aacute; este, indicar sempre a conta banc&aacute;ria de sua titularidade, a ag&ecirc;ncia, e a Institui&ccedil;&atilde;o financeira destinat&aacute;ria da referida import&acirc;ncia.</p>
<p align="justify" class="style2"> Par&aacute;grafo Segundo: Estendendo-se o prazo contratual, al&eacute;m do prazo de car&ecirc;ncia previsto no caput desta Cl&aacute;usula, sem manifesta&ccedil;&atilde;o por parte do CONTRATANTE &ndash; CLIENTE INVESTIDOR, os mecanismos operacionais de investimento da ASSESSORA CONTRATADA, prosseguir&atilde;o normalmente obedecendo as regras j&aacute; contidas neste Instrumento, excetuando-se apenas nos casos de resgate total dos valores investidos, ou, nos casos de aporte adicional por celebra&ccedil;&atilde;o de Termo Aditivo ou Adendo Contratual, nos casos de resgate parcial, ocasi&atilde;o em que, os mecanismos prosseguir&atilde;o de forma proporcional ao investimento.</p>
<p align="justify" class="style2"> Par&aacute;grafo Terceiro: Ap&oacute;s o t&eacute;rmino do prazo carencial contratual, os mecanismos operacionais de investimento da ASSESSORA CONTRATADA, prosseguir&atilde;o normalmente obedecendo as regras j&aacute; contidas neste Instrumento, cabendo ao CONTRATANTE &ndash; CLIENTE INVESTIDOR, e somente a este e a qualquer tempo, solicitar o resgate total do seu aporte, bem como, aumentar o valor aportado por celebra&ccedil;&atilde;o de Termo Aditivo ou ainda, requerer o resgate parcial dos valores aportados, mediante termo aditivo ou, celebra&ccedil;&atilde;o de um novo Instrumento.</p>
<p align="justify" class="style2"> Par&aacute;grafo Quarto: Ap&oacute;s a data das assinaturas deste Instrumento, a car&ecirc;ncia prevista no caput desta Cl&aacute;usula, poder&aacute; ser reduzida ou dilatada, exclusivamente mediante acordo formal de tal ocorr&ecirc;ncia, e, com a com concord&acirc;ncia mutua entre a ASSESSORA CONTRATADA e o CONTRATANTE<br>
  &ndash; CLIENTE INVESTIDOR.</p>
<p align="justify" class="style2"><strong>DA INJE&Ccedil;&Atilde;O DE CAPITAL ADICIONAL DURANTE A VIG&Ecirc;NCIA DO CONTRATO</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA QUINTA: O CONTRATANTE &ndash; CLIENTE INVESTIDOR, a qualquer momento, poder&aacute; aportar mais capital a fim de aumentar o lucro auferido. Entretanto, dever&aacute; ser realizado um adendo a este instrumento, especificando as novas condi&ccedil;&otilde;es, ocasi&atilde;o em que CONTRATANTE &ndash; CLIENTE<br>
  INVESTIDOR passar&aacute; a obter os lucros deste novo aporte somente ap&oacute;s 03 (tr&ecirc;s) dias &uacute;teis ap&oacute;s a data da sua celebra&ccedil;&atilde;o.<br>
  DA DATA INICIAL DOS RENDIMENTOS</p>
<p align="justify" class="style2">CL&Aacute;USULA SEXTA: O rendimento inicia a contagem em 01 (um) dia &uacute;teil da data do aporte, servindo o mesmo per&iacute;odo para a contagem de prazo inicial para novo aporte, servindo como regra b&aacute;sica para os Aditivos Contratuais.</p>
<p align="justify" class="style2"><strong>DA REMUNERA&Ccedil;&Atilde;O PELO CAPITAL INVESTIDO E DO RESGATE</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA S&Eacute;TIMA: Em contrapresta&ccedil;&atilde;o ao capital investido a ASSESSORA CONTRATADA creditar&aacute; na conta banc&aacute;ria indicada em nome do CONTRATANTE &ndash; CLIENTE INVESTIDOR, descrita na CL&Aacute;USULA TERCEIRA do presente Instrumento, uma remunera&ccedil;&atilde;o vari&aacute;vel de at&eacute; como lucro do valor aportado inicialmente, tomando como valor base, o valor investido e retroagido ao 90&ordm; (nonag&eacute;simo) dia anterior &agrave; data do levantamento do aporte investido.</p>
<p align="justify" class="style2"> Par&aacute;grafo Primeiro: Os percentuais de remunera&ccedil;&atilde;o descrito no caput desta Cl&aacute;usula, obedecem &agrave;s normas e padr&otilde;es estabelecidos pela CVM &ndash; Comiss&atilde;o de Valores Imobili&aacute;rios, estando em conformidade com os itens &ldquo;07&rdquo; e &ldquo;08&rdquo;, do Of&iacute;cio-Circular n&ordm; 2/2019/CVM/SIN, bem como, com a Instru&ccedil;&atilde;o CVM n&ordm; 400, de 29 de dezembro de 2003 e Instru&ccedil;&atilde;o CVM 598/18, artigo 14.</p>
<p align="justify" class="style2"> Par&aacute;grafo Segundo: Na hip&oacute;tese de rescis&atilde;o contratual antecipada por qualquer das partes, nos termos das CL&Aacute;USULAS D&Eacute;CIMA QUINTA e D&Eacute;CIMA SEXTA, a ASSESSORA CONTRATADA se<br>
  compromete em restituir o valor principal aportado no prazo de at&eacute; 30 (dias) &uacute;teis, incorrendo em multa de 20% (vinte por cento) sobre o valor principal para a parte que deu causa &agrave; rescis&atilde;o.</p>
<p align="justify" class="style2"> Par&aacute;grafo Terceiro: Sendo dada a causa para a rescis&atilde;o contratual antecipada, por parte do CONTRATANTE &ndash; CLIENTE INVESTIDOR, a respectiva multa ser&aacute; imediatamente descontada do valor a ser restitu&iacute;do pela ASSESSORA CONTRATADA, no mesmo prazo descrito no Par&aacute;grafo Segundo.</p>
<p align="justify" class="style2"><strong>DOS SERVI&Ccedil;OS PRESTADOS PELA ASSESSORA CONTRATADA</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA OITAVA: Obriga-se a ASSESSORA CONTRATADA, a prestar ao CONTRATANTE &ndash; CLIENTE<br>
  INVESTIDOR, a assessoria necess&aacute;ria para gerenciar os riscos dos recursos financeiros disponibilizados e aportados pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR, a fim de obter lucro sobre as opera&ccedil;&otilde;es decorrentes do montante total do capital investido, durante todo o per&iacute;odo de vig&ecirc;ncia do presente Instrumento.</p>
<p align="justify" class="style2"> Par&aacute;grafo Primeiro: A ASSESSORA CONTRATADA disponibilizar&aacute; ao CONTRATANTE &ndash; CLIENTE INVESTIDOR, os seguintes canais de atendimento e solu&ccedil;&otilde;es:</p>
<p align="justify" class="style2">1 &ndash; Contato na ASSESSORA CONTRATADA &ndash; Linha whatsapp, n&ordm; (41) 9 9282-3979</p>
<p align="justify" class="style2"><strong>DAS DECLARA&Ccedil;&Otilde;ES</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA NONA: O CONTRATANTE &ndash; CLIENTE INVESTIDOR neste ato declara:</p>
<p align="justify" class="style2">a) Que as informa&ccedil;&otilde;es cadastrais repassadas &agrave; ASSESSORA CONTRATADA para a efetiva&ccedil;&atilde;o do presente Instrumento s&atilde;o verdadeiras, assumindo o CONTRATANTE &ndash; CLIENTE INVESTIDOR para si, a responsabilidade civil, criminal e tribut&aacute;ria por estas informa&ccedil;&otilde;es, ratificando o Par&aacute;grafo Primeiro, da CL&Aacute;USULA TERCEIRA deste Instrumento;<br>
  b) Que tem ci&ecirc;ncia que a ASSESSORA CONTRATADA realiza a gest&atilde;o financeira de recursos pr&oacute;prios e de terceiros no mercado oficial em base de terceiros; atuando no mercado financeiro oscilante em gest&atilde;o de risco, operando com negocia&ccedil;&otilde;es de ativos digitais;<br>
  c) Estar ciente de que a ASSESSORA CONTRATADA reter&aacute; seu investimento aportado, por um prazo de car&ecirc;ncia m&iacute;nima de 90 (noventa) dias, de acordo com a CL&Aacute;USULA QUARTA e seus respectivos par&aacute;grafos;<br>
  d) Que tem ci&ecirc;ncia da expertise de mercado dos operadores da ASSESSORA CONTRATADA, e que n&atilde;o poder&aacute; interferir em hip&oacute;tese alguma, na estrat&eacute;gia de mercado utilizada pela ASSESSORA CONTRATADA, cabendo-lhe &uacute;nica e exclusivamente os rendimentos ofertados no caput da CLAUSULA S&Eacute;TIMA;<br>
  e) Que tem ci&ecirc;ncia e concorda com o Par&aacute;grafo Quinto, da CL&Aacute;USULA PRIMEIRA, de que todas as opera&ccedil;&otilde;es financeiras de DAY TRADING ser&atilde;o realizadas exclusivamente em nome da ASSESSORA CONTRATADA, e ou, em nome de seus s&oacute;cios de forma individual ou conjunta, utilizando-se do<br>
  sistema de nuvem com informa&ccedil;&otilde;es criptografadas, das quais, somente a ASSESSORA CONTRATADA ter&aacute; irrestrito acesso.<br>
  f) Que tem ci&ecirc;ncia de que o prazo m&iacute;nimo inicial de investimento ser&aacute; de 90 dias, a contar da confirma&ccedil;&atilde;o da transfer&ecirc;ncia ou dep&oacute;sito banc&aacute;rio;<br>
  g) Tem ci&ecirc;ncia de que o rendimento do capital investido come&ccedil;ar&aacute; a ser contabilizado ap&oacute;s 03 dias &uacute;teis, contados ap&oacute;s a confirma&ccedil;&atilde;o da transfer&ecirc;ncia ou dep&oacute;sito banc&aacute;rio;<br>
  h) Que o prazo m&iacute;nimo exigido no item &ldquo;c&rdquo;, &eacute; necess&aacute;rio e o suficiente para que a ASSESSORA CONTRATADA aplique suas estrat&eacute;gias de mercado e obtenha o resultado esperado;<br>
  i) Tem ci&ecirc;ncia de que, caso opte pelo cancelamento do seu contrato antes do prazo fixado no item &ldquo;c&rdquo;, ter&aacute; que pagar uma taxa, na modalidade de multa, no percentual de 20% (vinte por cento) sobre o valor aportado em seu investimento inicial, sendo referida multa, descontada imediatamente no momento do saque;<br>
  j) Tem ci&ecirc;ncia de que, caso solicite o saque ap&oacute;s os 90 dias iniciais, os juros ser&atilde;o calculados pro rata die, calculando-se proporcionalmente aos dias investidos;<br>
  k) Que est&aacute; de acordo que, ap&oacute;s solicita&ccedil;&atilde;o de saque, o valor ser&aacute; creditado somente em contas da mesma titularidade do CONTRATANTE &ndash; CLIENTE INVESTIDOR, sem nenhuma exce&ccedil;&atilde;o;<br>
  l) Que est&aacute; ciente que, o valor solicitado para retirada, ser&aacute; depositado no prazo de 05 dias &uacute;teis, ap&oacute;s recebimento pela ASSESSORA CONTRATADA, da confirma&ccedil;&atilde;o da solicita&ccedil;&atilde;o;<br>
  m) Que est&aacute; ciente que o valor do rendimento sempre ser&aacute; depositado no dia do mesvers&aacute;rio de investimento, na forma do Par&aacute;grafo Terceiro da CLAUSULA S&Eacute;TIMA do presente Instrumento;<br>
  n) Que quaisquer diverg&ecirc;ncias, entre as informa&ccedil;&otilde;es existentes no escrit&oacute;rio virtual e as informa&ccedil;&otilde;es fornecidas pelos representantes da ASSESSORA CONTRATADA, prevalecer&atilde;o estas &uacute;ltimas, desde que sejam formalizadas em documento oficial;<br>
  o) Ter ci&ecirc;ncia de que, a ASSESSORA CONTRATADA, n&atilde;o realiza pagamento em feriados, n&atilde;o realiza pagamentos aos finais de semana, n&atilde;o realiza pagamentos fora do hor&aacute;rio de expediente banc&aacute;rio, e ainda, de que os pagamentos realizados de segunda &agrave; sexta-feira dentro do expediente banc&aacute;rio, respeitar&atilde;o o fuso hor&aacute;rio da Sede - Matriz da ASSESSORA CONTRATADA, nos per&iacute;odos compreendidos como &ldquo;hor&aacute;rio de ver&atilde;o&rdquo;.</p>
<p align="justify" class="style2"><strong>DAS OBRIGA&Ccedil;&Otilde;ES DO CONTRATANTE &ndash; CLIENTE INVESTIDOR</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA D&Eacute;CIMA: O CONTRATANTE &ndash; CLIENTE INVESTIDOR se responsabiliza pela completa integraliza&ccedil;&atilde;o do capital declarado no termo de ades&atilde;o, obrigando-se, ap&oacute;s concordar e assinar o presente Instrumento, realizar a transfer&ecirc;ncia identificada do aporte para a CONTRATADA no prazo m&aacute;ximo de at&eacute; 02 (dois) dias, sob pena de rescis&atilde;o imediata do contrato;<br>
</p>
<p align="justify" class="style2"> Par&aacute;grafo Primeiro: O CONTRATANTE &ndash; CLIENTE INVESTIDOR se responsabiliza a depositar o valor em moeda corrente nacional por interm&eacute;dio DOC/TED/PIX em conta corrente de titularidade da ASSESSORA CONTRATADA, cujos dados ser&atilde;o informados por ocasi&atilde;o da contrata&ccedil;&atilde;o.</p>
<p align="justify" class="style2"> Par&aacute;grafo Segundo: Dever&aacute; o CONTRATANTE &ndash; CLIENTE INVESTIDOR, neste ato, indicar e informar abaixo, os dados completos da sua conta banc&aacute;ria para transfer&ecirc;ncia do lucro desta transa&ccedil;&atilde;o, e mant&ecirc;-la ativa at&eacute; a data do regate dos juros ou, da totalidade do aporte investido:</p>
<p align="justify" class="style2"> PIX: <?php echo $data['tipo_pix']; ?><br>
  Chave: <?php echo $data['chave']; ?></p>
<p align="justify" class="style2"> Par&aacute;grafo Terceiro: &Eacute; de responsabilidade exclusiva do CONTRATANTE &ndash; CLIENTE INVESTIDOR, e obrigando-se este, enquanto contribuinte, informar a Receita Federal do Brasil e declarar seus lucros no imposto de Renda vigente;</p>
<p align="justify" class="style2"> Par&aacute;grafo Quarto: O CONTRATANTE &ndash; CLIENTE INVESTIDOR, se responsabiliza em obter por meios pr&oacute;prios, o acesso ao escrit&oacute;rio virtual por interm&eacute;dio de representantes da ASSESSORA CONTRATADA.</p>
<p align="justify" class="style2"> Par&aacute;grafo Quinto: O CONTRATANTE &ndash; CLIENTE INVESTIDOR, obriga-se por meio do presente Instrumento, a manter sigilo necess&aacute;rio sobre suas contas e sobre os servi&ccedil;os prestados e sobre as opera&ccedil;&otilde;es financeiras realizadas pela ASSESSORA CONTRATADA.</p>
<p align="justify" class="style2"> Par&aacute;grafo Sexto: O CONTRATANTE &ndash; CLIENTE INVESTIDOR &eacute; integralmente respons&aacute;vel pela origem e proced&ecirc;ncia de valor investido nessas opera&ccedil;&otilde;es, de modo que em hip&oacute;tese alguma a CONTRATADA ser&aacute; responsabilizada caso a origem do mesmo seja considerado il&iacute;cita, tendo em vista desconhece &ndash; l&aacute;, ratificando o Par&aacute;grafo Primeiro, da CL&Aacute;USULA TERCEIRA, bem como, o &ldquo;item &ldquo;a&rdquo;&rdquo;, da CL&Aacute;USULA NONA deste Instrumento;</p>
<p align="justify" class="style2"> Par&aacute;grafo S&eacute;timo: O CONTRATANTE &ndash; CLIENTE INVESTIDOR, autoriza a ASSESSORA CONTRATADA,<br>
  para garantir a seguran&ccedil;a jur&iacute;dica do presente Instrumento, bem como, para a seguran&ccedil;a das partes contratantes, com ou sem sinal de advert&ecirc;ncia pr&eacute;vio, a gravar suas conversas telef&ocirc;nicas, e-mails, mensagens eletr&ocirc;nicas ou assemelhadas com colaboradores, prepostos ou representantes da CONTRATADA, pelo per&iacute;odo de 5 anos do t&eacute;rmino do contrato.</p>
<p align="justify" class="style2"><strong>DAS OBRIGA&Ccedil;&Otilde;ES DA ASSESSORA</strong></p>
<p align="justify" class="style2">CL&Aacute;SULA D&Eacute;CIMA PRIMEIRA: Al&eacute;m das obriga&ccedil;&otilde;es j&aacute; impl&iacute;citas no presente Instrumento, a ASSESSORA CONTRATADA, obriga-se a:</p>
<p align="justify" class="style2">a) Receber os dep&oacute;sitos dos capitais declarados para investimento na CL&Aacute;USULA TERCEIRA deste Instrumento, zelando pela efici&ecirc;ncia e efetividade das ferramentas digitais e equipamentos para realiza&ccedil;&atilde;o das opera&ccedil;&otilde;es em que a ASSESSORA CONTRATADA optar por realizar;<br>
  b) Fornecer ao CONTRATANTE &ndash; CLIENTE INVESTIDOR, o mais amplo suporte, utilizando de sua expertise e seu know-how para obten&ccedil;&atilde;o de lucro em favor do CONTRATANTE &ndash; CLIENTE INVESTIDOR;<br>
  c) Enviar confirma&ccedil;&atilde;o de recebimento das transfer&ecirc;ncias banc&aacute;rias, informando, inclusive, o termo inicial dos rendimentos;<br>
  d) Deixar o seu saldo investido pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR dispon&iacute;vel para saque ap&oacute;s os 90 (noventa) dias iniciais, podendo assim, ser retirado em qualquer momento, mais juros calculados pro rata die, proporcionais aos dias efetivamente deixados &agrave; sua disposi&ccedil;&atilde;o;<br>
  e) Ap&oacute;s a confirma&ccedil;&atilde;o de solicita&ccedil;&atilde;o de saque, a depositar os valores na conta corrente de titularidade do CONTRATANTE &ndash; CLIENTE INVESTIDOR no prazo m&aacute;ximo de 05 dias &uacute;teis, sob pena de incorrer na multa di&aacute;ria de 0,02% ao dia sobre o valor do saque, em favor do CONTRATANTE &ndash; CLIENTE INVESTIDOR.<br>
  f) Aplicar suas estrat&eacute;gias de investimentos, assumindo todo risco da opera&ccedil;&atilde;o, garantindo ao CONTRATANTE &ndash; CLIENTE INVESTIDOR, os rendimentos apontados no caput da CL&Aacute;USULA S&Eacute;TIMA;<br>
  g) Garantir a opera&ccedil;&atilde;o com recursos pr&oacute;prios, ou, de terceiros garantidores, devolvendo a integralidade do valor aportado pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR, por quaisquer motivos que venham causar a descontinuidade do contrato, observadas as declara&ccedil;&otilde;es da CL&Aacute;USULA NONA.<br>
  h) A observ&acirc;ncia das leis tribut&aacute;rias vigentes, devendo realizar as reten&ccedil;&otilde;es e recolhimentos dos impostos quando devidos, garantindo ao CONTRATANTE &ndash; CLIENTE INVESTIDOR a integralidade da remunera&ccedil;&atilde;o apontada no caput da CL&Aacute;USULA S&Eacute;TIMA, livre de impostos.</p>
<p align="justify" class="style2"><strong>DA VIG&Ecirc;NCIA E PRAZO CONTRATUAL</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA D&Eacute;CIMA SEGUNDA: O presente instrumento tem prazo de vig&ecirc;ncia inicial de 90 (noventa dias) corridos, iniciando-se a partir da assinatura das partes, com ades&atilde;o m&iacute;nima pelo mesmo prazo inicial de 90 (noventa) dias corridos, n&atilde;o podendo ser rescindido em data anterior ao respectivo per&iacute;odo, sob pena da multa contratual descrita na CL&Aacute;USULA D&Eacute;CIMA TERCEIRA<br>
</p>
<p align="justify" class="style2"> <strong>DA MULTA POR INFRA&Ccedil;&Atilde;O CONTRATUAL</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA D&Eacute;CIMA TERCEIRA: O CONTRATANTE &ndash; CLIENTE INVESTIDOR poder&aacute; ser multado em<br>
  20% (vinte por cento) do valor investido, caso requerer o saque antes do per&iacute;odo de car&ecirc;ncia inicial de 90 (noventa) dias.</p>
<p align="justify" class="style2">CL&Aacute;USULA D&Eacute;CIMA QUARTA: A ASSESSORA CONTRATADA poder&aacute; ser multada na ordem de 0,2% (zero v&iacute;rgula do&iacute;a por cento) por dia de atraso, caso n&atilde;o deposite os valores nos prazos estabelecidos neste contrato.</p>
<p align="justify" class="style2"> Par&aacute;grafo Primeiro: Qualquer multa porventura aplicada pela ASSESSORA CONTRATADA ser&aacute; considerada d&iacute;vida l&iacute;quida e certa, ficando a ASSESSORA CONTRATADA autorizada a descont&aacute;-la imediatamente &agrave; data do pr&oacute;ximo pagamento devido ao CONTRATANTE &ndash; CLIENTE INVESTIDOR ou cobr&aacute;-la judicialmente a seu crit&eacute;rio, servindo, para tanto, o presente instrumento como t&iacute;tulo executivo extrajudicial, com honor&aacute;rios advocat&iacute;cios devidos no percentual de 20% (vinte por cento), calculados sobre o valor da condena&ccedil;&atilde;o;</p>
<p align="justify" class="style2"> Par&aacute;grafo Segundo: Caso a ASSESSORA CONTRATADA atrasar qualquer das parcelas, o CONTRATANTE &ndash; CLIENTE INVESTIDOR tem o direito de cancelar a presta&ccedil;&atilde;o do servi&ccedil;o e as opera&ccedil;&otilde;es financeiras, se assim optar, isentando-o da multa prevista CL&Aacute;USULA D&Eacute;CIMA TERCEIRA, com a finaliza&ccedil;&atilde;o imediata do contrato e restitui&ccedil;&atilde;o do valor integralizado.<br>
  DA RECIS&Atilde;O</p>
<p align="justify" class="style2">CL&Aacute;USULA D&Eacute;CIMA QUINTA: Caso o CONTRATANTE &ndash; CLIENTE INVESTIDOR inadimplir quaisquer das CL&Aacute;USULAS constantes deste instrumento, em especial as descritas na CL&Aacute;USULA D&Eacute;CIMA TERCEIRA, a CONTRATADA tem o direito pleno imediato de rescindir o contrato.</p>
<p align="justify" class="style2">CL&Aacute;USULA DECIMA SEXTA: O presente CONTRATO DE INVESTIMENTO EM ALUGUEL DE CAPITAL FINANCEIRO PARA REALIZA&Ccedil;&Atilde;O DE OPERA&Ccedil;&Otilde;ES DE DAY TRADING, ser&aacute; considerado<br>
  automaticamente rescindido, independentemente de pr&eacute;via notifica&ccedil;&atilde;o, al&eacute;m dos casos previstos em lei, se ocorrido qualquer dos seguintes eventos:</p>
<p align="justify" class="style2">a) Descumprimento integral, pelas partes, de qualquer das disposi&ccedil;&otilde;es deste Contrato, hip&oacute;tese em que as caber&aacute; a multa de 20% (vinte por cento) a parte que deu causa;</p>
<p align="justify" class="style2">b) Deferimento, requerimento ou decreta&ccedil;&atilde;o de interven&ccedil;&atilde;o, liquida&ccedil;&atilde;o ou dissolu&ccedil;&atilde;o extrajudicial, recupera&ccedil;&atilde;o judicial ou extrajudicial, ou fal&ecirc;ncia da ASSESSORA CONTRATADA.</p>
<p align="justify" class="style2">Par&aacute;grafo &Uacute;nico: Caso o CONTRATANTE &ndash; CLIENTE INVESTIDOR manifeste a vontade em desistir do pactuado neste contrato, dever&aacute; faz&ecirc;-lo expressamente, descrevendo os motivos de sua desist&ecirc;ncia, incorrendo em multa especificada na CLAUSULA D&Eacute;CIMA TERCEIRA.</p>
<p align="justify" class="style2"><strong>RESPONSABILIDADES E INDENIZA&Ccedil;&Atilde;O</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA D&Eacute;CIMA S&Eacute;TIMA: A ASSESSORA CONTRATADA n&atilde;o poder&aacute; ser responsabilizada por quaisquer danos ou preju&iacute;zos sofridos, ou que venham a ser sofridos, pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR, e que sejam decorrentes de:<br>
  a) Morte, incapacidade ou insolv&ecirc;ncia civil do CONTRATANTE &ndash; CLIENTE INVESTIDOR;<br>
  b) Atos culposos ou dolosos praticados por terceiros que venham afetar o cumprimento contratual;<br>
  c) Interrup&ccedil;&atilde;o nos sistemas de comunica&ccedil;&atilde;o, problemas oriundos de falhas ou interven&ccedil;&otilde;es de qualquer prestador de servi&ccedil;os de comunica&ccedil;&otilde;es ou de outra natureza ou, ainda, falhas na disponibilidade e acesso aos sistemas de envio dados ou em suas respectivas redes, conforme aplic&aacute;vel;<br>
  d) Interrup&ccedil;&atilde;o, suspens&atilde;o ou bloqueio pela ASSESSORA CONTRATADA, em raz&atilde;o do uso indevido pelo CONTRATANTE &ndash; CLIENTE INVESTIDOR, bem como daqueles destinados &agrave; prote&ccedil;&atilde;o contra v&iacute;rus e invas&otilde;es, de acesso &agrave; internet, de provedor e de configura&ccedil;&otilde;es necess&aacute;rias, conforme aplic&aacute;vel;<br>
  e) Interrup&ccedil;&atilde;o dos servi&ccedil;os prestados pela ASSESSORA CONTRATADA, nos termos deste Contrato, devido &agrave; decorr&ecirc;ncia de caso fortuito ou for&ccedil;a maior, nos termos do artigo 393 do C&oacute;digo Civil (&ldquo;O devedor n&atilde;o responde pelos preju&iacute;zos resultantes de caso fortuito ou for&ccedil;a maior, se expressamente n&atilde;o se houver por eles responsabilizado.&rdquo;)<br>
  f) Bloqueio ou penhora judicial que possa ocorrer em nome do CONTRATANTE &ndash; CLIENTE INVESTIDOR, que atinja diretamente o capital aportado, sob responsabilidade de reten&ccedil;&atilde;o dos juros obtidos por todo o per&iacute;odo contratual, &agrave; t&iacute;tulo de &ldquo;perdas e danos&rdquo;.</p>
<p align="justify" class="style2"><strong>DO FUNDO GARANTIDOR DA ASSESSORA CONTRATADA</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA D&Eacute;CIMA OITAVA: Caso ocorra algum imprevisto com o capital por parte da ASSESSORA CONTRATADA, esta responsabilizar-se-&aacute; integralmente pelas perdas e danos, utilizando-se para tanto, o necess&aacute;rio e dispon&iacute;vel no fundo garantidor da empresa, devolvendo o capital investido pelo contratante, acrescido dos valores auferidos em seus rendimentos diretos.</p>
<p align="justify" class="style2"><strong>DO FALECIMENTO E DA SUCESS&Atilde;O</strong></p>
<p align="justify" class="style2">CL&Aacute;USULA D&Eacute;CIMA NONA: O presente instrumento obriga os herdeiros e /ou sucessores das partes contratantes, a qualquer t&iacute;tulo.<br>
</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA: Em caso de falecimento ou de incapacidade declarada judicialmente do CONTRATANTE &ndash; CLIENTE INVESTIDOR, poder&atilde;o os herdeiros e ou sucessores do falecido(a) ingressar(em) como parte integrante do investimento em sua substitui&ccedil;&atilde;o (desde que haja anu&ecirc;ncia plena expressa de todos os sucessores), ou ent&atilde;o solicitar o resgate do valor principal aportado.</p>
<p align="justify" class="style2">DAS DISPOSI&Ccedil;&Otilde;ES GERAIS</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA PRIMEIRA: A est&aacute; autorizada a, agindo de forma preventiva e a fim de proteger a integridade de seus sistemas de negocia&ccedil;&atilde;o utilizados, alterar, a qualquer tempo, os limites operacionais e de risco aplic&aacute;veis ao CONTRATANTE &ndash; CLIENTE INVESTIDOR, de acordo com seus pr&oacute;prios crit&eacute;rios e procedimentos de administra&ccedil;&atilde;o de risco.</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA SEGUNDA: O CONTRATANTE &ndash; CLIENTE INVESTIDOR e a ASSESSORA<br>
  CONTRATADA, em iguais condi&ccedil;&otilde;es, n&atilde;o devem utilizar pr&aacute;ticas enganosas, desleais, e/ ou fraudulentas para a ades&atilde;o de novos investidores, SENDO ESTRITAMENTE PROIBIDO o aferimento de ganhos em comiss&otilde;es decorrentes de indica&ccedil;&otilde;es de novos investidores EM NENHUMA HIP&Oacute;TESE.</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA TERCEIRA: O presente CONTRATO DE INVESTIMENTO EM ALUGUEL DE CAPITAL FINANCEIRO PARA REALIZA&Ccedil;&Atilde;O DE OPERA&Ccedil;&Otilde;ES DE DAY TRADING, somente poder&aacute; ser<br>
  alterado / modificado mediante acordo m&uacute;tuo entre as partes, expressa e formalmente na modalidade do adendo.</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA QUARTA: As partes, em iguais condi&ccedil;&otilde;es n&atilde;o est&atilde;o autorizadas a fornecer declara&ccedil;&atilde;o a respeito deste contrato &agrave; terceiros, EM NENHUMA HIP&Oacute;TESE, bem como, se obrigam a n&atilde;o passarem informa&ccedil;&otilde;es pessoais ou cadastrais sobre as partes contratantes.</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA QUINTA: O CONTRATANTE &ndash; CLIENTE INVESTIDOR poder&aacute; indicar pessoas<br>
  para a ASSESSORA CONTRATADA, por&eacute;m n&atilde;o receber&aacute; nenhum valor pelas condi&ccedil;&otilde;es efetuadas, sendo um servi&ccedil;o gratuito, ratificando assim, o conte&uacute;do da CL&Aacute;USULA VIG&Eacute;SIMA TERCEIRA.</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA SEXTA: O presente instrumento particular &eacute; regulamentado pela legisla&ccedil;&atilde;o civil, comercial, financeira e tribut&aacute;ria em vig&ecirc;ncia, n&atilde;o podendo ser caracterizado, em hip&oacute;tese alguma, v&iacute;nculo empregat&iacute;cio ou associativo entre o CONTRATANTE &ndash; CLIENTE INVESTIDOR e a ASSESSORA CONTRATADA.</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA S&Eacute;TIMA: As partes CONTRATANTE &ndash; CLIENTE INVESTIDOR e a ASSESSORA<br>
  CONTRATADA reconhecem que:<br>
</p>
<p align="justify" class="style2">a) O n&atilde;o exerc&iacute;cio, por qualquer das partes, ou atraso no exerc&iacute;cio de qualquer direito que seja assegurado por este Contrato ou por lei, n&atilde;o constituir&aacute; nova&ccedil;&atilde;o ou ren&uacute;ncia de tal direito, prejudicar&aacute; o eventual exerc&iacute;cio deste, nos termos previstos neste Contrato;<br>
  b) A ren&uacute;ncia por qualquer das Partes, de qualquer direito aqui previsto somente ser&aacute; v&aacute;lida e eficaz se formalizada por escrito;<br>
  c) A nulidade ou invalidade de qualquer das disposi&ccedil;&otilde;es deste Contrato n&atilde;o prejudicar&aacute; a validade e efic&aacute;cia de suas demais disposi&ccedil;&otilde;es e do pr&oacute;prio Contrato;<br>
  d) Este Contrato constitui o acordo integral entre as partes, superando quaisquer entendimentos orais ou escritos anteriores.</p>
<p align="justify" class="style2">CL&Aacute;USULA VIG&Eacute;SIMA OITAVA: As partes por si, seus herdeiros e/ ou sucessores, convencionam entre si livremente, para dirimir quaisquer d&uacute;vidas, demandas, controv&eacute;rsias ou procedimentos judiciais oriundos do presente CONTRATO DE INVESTIMENTO EM ALUGUEL DE CAPITAL FINANCEIRO PARA REALIZA&Ccedil;&Atilde;O DE OPERA&Ccedil;&Otilde;ES DE DAY TRADING, ou a ele referente, elegendo o Foro da Comarca de Maring&aacute; - PR, com ren&uacute;ncia expressa de qualquer outro por mais privilegiado que seja, ou que se torne.</p>
<p align="justify" class="style2">&emsp;<br>
  E por estarem assim, justas e contratadas assinam o presente instrumento e seus anexos em 02 (duas) vias de igual teor e forma, rubricadas para que produzam seus jur&iacute;dicos legais, para todos os fins de direito, e na presen&ccedil;a de duas testemunhas abaixo.</p>
<p align="center" class="style2">&nbsp; </p>
<p align="center" class="style2">Maring&aacute;, <?php echo date('d'); ?> de <?php echo $mes; ?> de <?php echo date('Y'); ?>.</p>
<p align="center" class="style2"><strong><br>
    F&Aacute;BIO VIEIRA</strong><br>
  CPF N&ordm; 009.940.619-51</p>
<p align="center" class="style2"><br>
  <strong><?php echo $data['nome']; ?></strong><br>
  CPF N&deg; <?php echo $data['cpf']; ?>
</p>