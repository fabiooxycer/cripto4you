<script type="text/javascript">
    $("#cep").mask("00000-000");
</script>

<script>
    $(document).ready(function() {

        function limpa_formulário_cep() {
            $("#endereco").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#estado").val("");
        }
        $("#cep").blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != "") {
                var validacep = /^[0-9]{8}$/;
                if (validacep.test(cep)) {
                    $("#endereco").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#estado").val("...");
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            $("#endereco").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#estado").val(dados.uf);
                        } else {
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } else {
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limpa_formulário_cep();
            }
        });
    });
</script>

<script type='text/javascript'>
    var behavior = function(val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        options = {
            onKeyPress: function(val, e, field, options) {
                field.mask(behavior.apply({}, arguments), options);
            }
        };

    $('.phone').mask(behavior, options);
</script>

<script>
    $("#cpf").keydown(function(){
    try {
        $("#cpf").unmask();
    } catch (e) {}

    var tamanho = $("#cpf").val().length;

    if(tamanho < 11){
        $("#cpf").mask("999.999.999-99");
    } else {
        $("#cpf").mask("99.999.999/9999-99");
    }

    // ajustando foco
    var elem = this;
    setTimeout(function(){
        // mudo a posição do seletor
        elem.selectionStart = elem.selectionEnd = 10000;
    }, 0);
    // reaplico o valor para mudar o foco
    var currentValue = $(this).val();
    $(this).val('');
    $(this).val(currentValue);
});
</script>

<script>
    function verifica(value) {
        var input = document.getElementById("chave_pix");

        if (value == 'Chave Aleatória') {
            input.disabled = false;
        }
        if (value == 'E-mail') {
            input.disabled = false;
        }
        if (value == 'CNPJ') {
            input.disabled = false;
        }
        if (value == 'CPF') {
            input.disabled = false;
        }
        if (value == 'Telefone') {
            input.disabled = false;
        } else if (value == 'Não Possuo') {
            input.disabled = true;
        }
    };
</script>

<script language="javascript">
  function moeda(a, e, r, t) {
    let n = "",
      h = j = 0,
      u = tamanho2 = 0,
      l = ajd2 = "",
      o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
      return !0;
    if (n = String.fromCharCode(o),
      -1 == "0123456789".indexOf(n))
      return !1;
    for (u = a.value.length,
      h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
    ;
    for (l = ""; h < u; h++)
      -
      1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
      0 == (u = l.length) && (a.value = ""),
      1 == u && (a.value = "0" + r + "0" + l),
      2 == u && (a.value = "0" + r + l),
      u > 2) {
      for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
        3 == j && (ajd2 += e,
          j = 0),
        ajd2 += l.charAt(h),
        j++;
      for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
        a.value += ajd2.charAt(h);
      a.value += r + l.substr(u - 2, u)
    }
    return !1
  }
</script>