<?php

namespace Source\Data;

use CoffeeCode\DataLayer\DataLayer;
use \nusoap_client;
use Source\Models\ClientUpdate;
use Source\Models\User;

final class CrediLink
{
    private  $clientResponseRAW;
    private  $clientResponseObject;
    private  $requestParams;
    private  $client;

    public function __construct()
    {
        $this->makeClientInstance();
    }

    protected function makeClientInstance(): void
    {
        $this->client = new nusoap_client(
            CREDILINK_API_HOST,
            'wsdl'
        );

        $this->detectError();
    }

    protected function detectError(): void
    {
        if($this->client->getError()) {
            throw new \Exception($this->client->getError());
        } else if($this->client->fault) {
            throw new \Exception($this->clientResponseRAW);
        }
    }

    public function getDataFromCpfCnpj(string $cpfCnpj): DataLayer
    {
        $cpfCnpj = preg_replace('/[^0-9]/mi', '', $cpfCnpj);

        $this->makeCall('Cpfcnpj', [
            'cpfcnpj' => $cpfCnpj,
        ]);

        return $this->makeDataLayer();
    }

    protected function setRequestParams(array $params): void
    {
        /*$this->requestParams = array_merge($params, [
            'usuario' => CREDILINK_API_USER,
            'password' => CREDILINK_API_PASS,
            'sigla' => CREDILINK_API_SECRET,
        ]);*/
        $user = (new User())->UserLog();
        $this->requestParams = array_merge($params, [
            'usuario' =>  $user->account()->user_api,
            'password' => $user->account()->password_api,
            'sigla' => $user->account()->sigla_api,
        ]);
    }

    /**
     * @method BcoRenner(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method BcoSafra(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $telefone1, string $telefone2)
     * @method BcoSafraReceita(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method Cep(string $usuario, string $password, string $sigla, string $cep, string $numeroinicial, string $numerofinal, string $complemento, string $nome)
     * @method CepClaro(string $usuario, string $password, string $sigla, string $cep)
     * @method CepPaginacao(string $usuario, string $password, string $sigla, string $cep, string $numeroinicial, string $numerofinal, string $complemento, string $nome ▶
     * @method Comercial(string $usuario, string $password, string $sigla, string $cpf)
     * @method ComercialPaginacao(string $usuario, string $password, string $sigla, string $cpf, int $pagina)
     * @method Cpfcnpj(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method CpfcnpjClaro(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method CpfcnpjClearSale(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method CpfcnpjProcon(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method CredilinkClearSale(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method CredilinkPrevinity(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method CredilinkProcob(string $usuario, string $password, string $sigla, string $cpfcnpj, string $cep, string $telefone1, string $telefone2)
     * @method Dacasa(string $usuario, string $password, string $sigla, string $cpfcnpj, string $telefone)
     * @method DepsCnpj(string $usuario, string $senha, string $sigla, string $cpfcnpj)
     * @method DepsCpf(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $datanascimento)
     * @method Email(string $usuario, string $password, string $sigla, string $email)
     * @method Endereco(string $usuario, string $password, string $sigla, string $logradouro, string $numeroinicial, string $numerofinal, string $complemento, string $b ▶
     * @method EnderecoProcon(string $usuario, string $password, string $sigla, string $logradouro, string $numeroinicial, string $numerofinal, string $complemento, str ▶
     * @method Fortlev(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method Generali(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method GeneraliMCpf(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method Mongeral(string $usuario, string $senha, string $sigla, string $cpfcnpj)
     * @method Nome(string $usuario, string $password, string $sigla, string $nome, string $uf, string $bairro, string $cidade)
     * @method Obito(string $usuario, string $password, string $sigla, string $cpf)
     * @method ObitoResolv(string $usuario, string $password, string $sigla, stringArray $dadosConsulta, string $tipoConsulta, string $tipoResposta)
     * @method Parentes(string $usuario, string $password, string $sigla, string $cpf)
     * @method ParentesPaginacao(string $usuario, string $password, string $sigla, string $cpf, int $pagina)
     * @method ParentesProcon(string $usuario, string $password, string $sigla, string $cpf)
     * @method SafraCnpj(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $razaosocial)
     * @method StarTecnologia(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method Telefone(string $usuario, string $password, string $sigla, string $telefone)
     * @method TelefoneClearSale(string $usuario, string $password, string $sigla, string $telefone)
     * @method TelefoneProcon(string $usuario, string $password, string $sigla, string $telefone)
     * @method TempoServico(string $usuario, string $senha, string $sigla, string $cpfcnpj)
     * @method Teste(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method ValidaCpfPublico(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method Veiculos(string $usuario, string $password, string $sigla, string $cpfcnpj, string $chassi, string $renavan, string $placa)
     * @method Vizinhos(string $usuario, string $password, string $sigla, string $cpfcnpj, string $numero, string $cep, string $tipopesq)
     * @method VizinhosProcon(string $usuario, string $password, string $sigla, string $cpfcnpj, string $numero, string $cep, string $tipopesq)
     * @method WsEcomprador(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method WsEcompradorOnLine(string $usuario, string $password, string $sigla, string $cpfcnpj, string $datanascimento)
     * @method WsViaVarejo(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method WsViaVarejoDtNasc(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method WsZipBusinez(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method bloqueioProcon(string $usuario, string $sigla, string $password, string $telefone)
     * @method buscape(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $razaosocial)
     * @method cnpjReceita(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $datanascimento)
     * @method cnpjcomsocios(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method completo(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoBV(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoBancoOriginal(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoBancoPaulista(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method completoBanrisul(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method completoBrasilCard(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoCCB(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $datanascimento, int $tipoconsulta)
     * @method completoCCB2(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method completoCoopercard(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoCredZ(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoDaycoval(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method completoDeps(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method completoEmail(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $email)
     * @method completoFinsol(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoForegon(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoHand(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoHistorico(string $usuario, string $senha, string $sigla, string $cpfcnpj)
     * @method completoHistoricoA(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoInovamind(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoListo(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoMPMG(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoMarisa(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoMaxima(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method completoOmni(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoOpcaoObito(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, int $pesquisaObito)
     * @method completoPAN(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoPicpay(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, int $nomesocial)
     * @method completoQuanam(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoReceita(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method completoReceitaAlelo(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone, string $datanascimento)
     * @method completoWalmart(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method completoWhatsapp(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method cpfNome(string $usuario, string $senha, string $sigla, string $cpfcnpj)
     * @method getMailingCor(string $usuario, string $senha, string $sigla, string $nome, string $data_nascimentoInicial, string $data_nascimentoFinal, string $nome_mae ▶
     * @method neocrm(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method nomedatanasc(string $usuario, string $password, string $sigla, string $nome, string $datanasc)
     * @method siteConfirmeCpfCnpjOnLine(string $cpf, string $token)
     * @method valecardCNPJ(string $usuario, string $password, string $sigla, string $cnpj)
     * @method valecardCPF(string $usuario, string $password, string $sigla, string $cpf)
     * @method wsBancoSifra(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method wsBolt(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method wsCrediare(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $nome, string $telefone)
     * @method wsCrediareCpfCnpj(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method wsCredishop(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method wsDaycovalPGFN(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $tipoPesquisa)
     * @method wsLatam(string $usuario, string $senha, string $sigla, string $cpfcnpj, string $datanascimento)
     * @method wsNeoCambio(string $usuario, string $senha, string $sigla, string $cpfcnpj)
     * @method wsPNConsig(string $usuario, string $password, string $sigla, string $cpfcnpj)
     * @method wsSspi(string $usuario, string $password, string $sigla, string $nome, string $uf, int $quantidade)
     */
    protected function makeCall(string $action, array $params): void
    {
        $this->setRequestParams($params);
        $this->parseResponse($this->client->call($action, $this->requestParams));
    }

    private function parseResponse(string $response): void
    {
        $this->clientResponseRAW = trim($response);

        $this->detectError();

        $response = $this->sanitizeResponse($this->clientResponseRAW);

        $response = simplexml_load_string($response);

        if(!$response || isset($response->MSG)) {
            $this->client->setError(isset($response->MSG) ? (string) $response->MSG : "Invalid response");
            $this->detectError();
        }

        $this->clientResponseObject = json_decode(
            str_replace(
                [':[]', ':{}'],
                ':null',
                json_encode($response)
            )
        );

        // adequanto array de objetos
        // se vier apenas um item, array de um único objeto
        if(!is_array($this->clientResponseObject->REGISTRO)) $this->clientResponseObject->REGISTRO = [$this->clientResponseObject->REGISTRO];
    }

    private function makeDataLayer(): DataLayer
    {
        $client = new ClientUpdate;

        /**
         * O primeiro registro possui o endereço mais recente
         */
        $registro = array_shift($this->clientResponseObject->REGISTRO);

        $client->nascimento = trim($registro->NASC);

        $client->endereco = trim(join(" ", [
            $registro->ENDERECO,
            $registro->NUMERO,
            $registro->COMPLEMENTO,
        ]));

        $client->bairro = $registro->BAIRRO;
        $client->cidade = $registro->CIDADE;
        $client->uf = $registro->UF;
        $client->cep = $registro->CEP;

        /**
         * Percorrer todos os telefones e e-mails
         */
        array_push($this->clientResponseObject->REGISTRO, $registro);

        $count = 1;

        while($registro = array_shift($this->clientResponseObject->REGISTRO)) {
            // caso ainda esteja sem e-mail
            // a API retorna vários, mas nosso banco suporta apenas 1
            if(!isset($client->email) && $registro->EMAILS) {
                foreach(explode(',', $registro->EMAILS) as $email) {
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $client->email = $email;
                        break;
                    }
                }
            }

            if($registro->TELEFONE && strlen($registro->TELEFONE) >= 10) {
                $client->{"telefone_" . str_pad($count, 2, '0', STR_PAD_LEFT)} = $registro->TELEFONE;
            }

            $count++;
        }

        return $client;
    }

    private function sanitizeResponse(string $response): string
    {
        $response = utf8_decode($response);

        $response = preg_replace(
            '/\(.*?\)/mi',
            '',
            str_replace(['>NULL<'], '><', $response)
        );

        return $response;
    }
}