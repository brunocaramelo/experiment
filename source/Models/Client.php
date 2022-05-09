<?php

namespace Source\Models;

use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;
use Source\Support\Message;
use Exception;

/**
 * Description of Level
 *
 * @author Luiz
 */
class Client extends DataLayer
{

    public function __construct()
    {
        $base_client = User::UserLog()->base_client;
        parent::__construct("{$base_client}.client", ["NOME"]);
        //parent::__construct("client", ["NOME"]);
    }

    /**
     * Método para salvar ou alterar um usuário
     * @return bool
     */
    public function save(): bool
    {

        if (empty($this->id)) {

            if (!parent::save()) {
                return false;
            }

            $log = new Log();

            $log->account_id = User::UserLog()->account_id;
            $log->user = User::UserLog()->id;
            $log->ip = $_SERVER["REMOTE_ADDR"];
            $log->description = "Inclusão de dados de cliente " . $this->NOME;
            $log->save();
        } else {

            if (!parent::save()) {
                return false;
            }

            if ($this->status == 1 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Atualização do cliente " . $this->NOME;
                $log->save();
            }

            if ($this->status == 2 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Exclusão do cliente " . $this->NOME;
                $log->save();
            }

            if ($this->status == 3 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Bloqueio do cliente " . $this->NOME;
                $log->save();
            }
        }

        return true;
    }

    /**
     * @return Organ|null
     */
    public function organDesc(): ?Organ
    {
        if ($this->CLIENT_ORGAN) {
            return (new Organ())->findById($this->CLIENT_ORGAN);
        }
        return null;
    }

    /**
     * @return BankCod|null
     */
    public function clientBank(): ?BankCod
    {
        if ($this->BANCO) {
            return (new BankCod())->find("cod=:b", "b={$this->BANCO}")->fetch();
        }
        return null;
    }

    public function searchClient($base, $organ)
    {
        $connect = Connect::getInstance();

        $clients = $connect->query("SELECT CPF,NOME,NASCIMENTO,BANCO FROM " . $base . ".client  WHERE CLIENT_ORGAN = " . $organ . " group by nome ORDER BY Rand() LIMIT 3 ");

        return $clients->fetchAll();
    }

    /**
     * @return OrganFilter|null
     */
    public function organFilterDesc()
    {
        $connect = Connect::getInstance();

        $organ = $connect->query("SELECT description FROM organ_filter  WHERE cod_organ = " . $this->ORGAO . "  ");

        return $organ->fetchAll();
    }

    /**
     * @return Client|null
     */
    public function returnClient($organ, $indicative, $category, $patent, $state, $city, $legal_regime, $bank, $portions, $until_portion, $rest_portion, $until_rest_portion, $bank_descounts, $bank_not_descounts, $margin_of, $until_margin_of, $margin_percent, $until_margin_percent, $age_of, $age_until, $attendance_retorn_id, $attendence_of, $until_attendence_of, $ignore_actived_filters, $dont_ignore_client)
    {
        $base_client = User::UserLog()->base_client;

        $connect = Connect::getInstance();
        $query = "SELECT * FROM {$base_client}.client WHERE CLIENT_ORGAN = " . $organ . "   ";

        if ($indicative) {
            $query .= " AND ( ";
            foreach ($indicative as $counter => $each) {
                if ($counter == 0) {
                    $query .= "  INDICATIVO ='" . $each->indicative_id . "' ";
                } else {
                    $query .= " OR INDICATIVO = '" . $each->indicative_id . "' ";
                }
            }
            $query .= " ) ";
        }

        /*if ($organ != 4) {
            if (isset($category)) {
                if (count($category) != 0) {
                    $query .= " AND ( ";
                    foreach ($category as $counter => $each) {
                        if ($counter == 0) {
                            $query .= "  CATEGORIAS ='" . $each->description . "' ";
                        } else {
                            $query .= " OR CATEGORIAS = '" . $each->description . "' ";
                        }
                    }
                    $query .= " ) ";
                }
            }
        } else {
            if (isset($category)) {
                if (count($category) != 0) {
                    $query .= " AND ( ";
                    foreach ($category as $counter => $each) {
                        if ($counter == 0) {
                            $query .= "  SIT_FUNCIONAL ='" . $each->description . "' ";
                        } else {
                            $query .= " OR SIT_FUNCIONAL = '" . $each->description . "' ";
                        }
                    }
                    $query .= " ) ";
                }
            }
        }*/
		
		    if (isset($category)) {
                if (count($category) != 0) {
                    $query .= " AND ( ";
                    foreach ($category as $counter => $each) {
                        if ($counter == 0) {
                            $query .= "  CATEGORIAS ='" . $each->description . "' ";
                        } else {
                            $query .= " OR CATEGORIAS = '" . $each->description . "' ";
                        }
                    }
                    $query .= " ) ";
                }
            }

        if (isset($patent)) {
            if (count($patent) != 0) {
                $query .= " AND ( ";
                foreach ($patent as $counter => $each) {
                    if ($counter == 0) {
                        $query .= "  PATENTE ='" . $each->description . "' ";
                    } else {
                        $query .= " OR PATENTE = '" . $each->description . "' ";
                    }
                }
                $query .= " ) ";
            }
        }

        if (isset($legal_regime)) {
            if (count($legal_regime) != 0) {
                $query .= " AND ( ";
                foreach ($legal_regime as $counter => $each) {
                    if ($counter == 0) {
                        $query .= "  RUUR ='" . $each->description . "' ";
                    } else {
                        $query .= " OR RUUR = '" . $each->description . "' ";
                    }
                }
                $query .= " ) ";
            }
        }

        if ($age_of == "0") {

            if ($age_until != "0") {
                $query .= " AND TIMESTAMPDIFF(YEAR, NASCIMENTO,NOW()) <='" . $age_until . "' ";
            }
        } else {
            if ($age_until != "0") {
                $query .= " AND TIMESTAMPDIFF(YEAR, NASCIMENTO,NOW()) BETWEEN '" . $age_of . "' AND '" . $age_until . "' ";
            } else {
                $query .= " AND TIMESTAMPDIFF(YEAR, NASCIMENTO,NOW())>='" . $age_of . "' ";
            }
        }

        if ($margin_of == "0.00") {

            if ($until_margin_of != "0.00") {
                $query .= " AND CAST(REPLACE(REPLACE(MARGEM_CONSIG,'.',''),',','.') AS decimal(10,2))<='" . $until_margin_of . "' ";
            }
        } else {

            if ($until_margin_of != "0.00") {
                $query .= " AND CAST(REPLACE(REPLACE(MARGEM_CONSIG,'.',''),',','.') AS decimal(10,2)) BETWEEN '" . $margin_of . "' AND '" . $until_margin_of . "' ";
            } else {
                $query .= " AND CAST(REPLACE(REPLACE(MARGEM_CONSIG,'.',''),',','.') AS decimal(10,2))>='" . $margin_of . "' ";
            }
        }

        if ($margin_percent == "0.00") {

            if ($until_margin_percent != "0.00") {
                $query .= " AND CAST(REPLACE(REPLACE(MARGEM_CARTAO,'.',''),',','.') AS decimal(10,2))<='" . $until_margin_percent . "' ";
            }
        } else {

            if ($until_margin_percent != "0.00") {
                $query .= " AND CAST(REPLACE(REPLACE(MARGEM_CARTAO,'.',''),',','.') AS decimal(10,2)) BETWEEN '" . $margin_percent . "' AND '" . $until_margin_percent . "' ";
            } else {
                $query .= " AND CAST(REPLACE(REPLACE(MARGEM_CARTAO,'.',''),',','.') AS decimal(10,2))>='" . $margin_percent . "' ";
            }
        }

        if (count($bank) != 0) {
            $query .= " AND ( ";
            foreach ($bank as $counter => $each) {
                $bank_peace = explode("-", $each->bank);
                $bank_result = ltrim(trim($bank_peace[0]), '0');
                if ($counter == 0) {
                    $query .= "  BANCO ='" . $bank_result . "' ";
                } else {
                    $query .= " OR BANCO = '" . $bank_result . "' ";
                }
            }
            $query .= " ) ";
        }

        if (count($state) != 0) {
            $query .= " AND ( ";
            foreach ($state as $counter => $each) {
                if ($counter == 0) {
                    $query .= "  UF ='" . returnState($each->uf_descricao) . "' ";
                } else {
                    $query .= " OR UF = '" . returnState($each->uf_descricao) . "' ";
                }
            }
            $query .= " ) ";
        }

        if (count($city) != 0) {
            $query .= " AND ( ";
            foreach ($city as $counter => $each) {
                if ($counter == 0) {
                    $query .= "  CIDADE ='" . $each->cidade_descricao . "' ";
                } else {
                    $query .= " OR CIDADE = '" . $each->cidade_descricao . "' ";
                }
            }
            $query .= " ) ";
        }

        if ($organ == 1) {


            if (count($bank_not_descounts) != 0) {
                $query .= " AND CPF not in ( SELECT CPF FROM {$base_client}.client_exercito WHERE BANCO in (";
                foreach ($bank_not_descounts as $counter => $each) {
                    //$pieces_bank = explode("-",$each->bank);
                    if ($counter == 0) {
                        $query .= "'" . $each->bank . "'";
                    } else {
                        $query .= "," . "'" . $each->bank . "'";
                    }
                }

                $query .= ") ) ";
            }

            if (count($bank_descounts) != 0) {
                $query .= " AND CPF in ( SELECT CPF FROM {$base_client}.client_exercito WHERE BANCO in (";
                foreach ($bank_descounts as $counter => $each) {
                    //$pieces_bank = explode("-",$each->bank);
                    if ($counter == 0) {
                        $query .= "'" . $each->bank . "'";
                    } else {
                        $query .= "," . "'" . $each->bank . "'";
                    }
                }

                $query .= ") ) ";
            }
            if ($portions == "0.00") {

                if ($until_portion != "0.00") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_exercito WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))<='" . $until_portion . "' )";
                }
            } else {

                if ($until_portion != "0.00") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_exercito WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) BETWEEN '" . $portions . "' AND '" . $until_portion . "'  )";
                } else {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_exercito WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))>='" . $portions . "') ";
                }
            }

            /*if ($rest_portion == "0") {

                if ($until_rest_portion != "0") {
                    $query .= " AND PREC_CP IN(SELECT PREC_CP FROM {$base_client}.client_exercito WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') )<='" . $until_rest_portion . "'  )";
                }
            } else {
                if ($until_rest_portion != "0") {
                    $query .= " AND PREC_CP IN(SELECT PREC_CP FROM {$base_client}.client_exercito WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') ) BETWEEN '" . $rest_portion . "' AND '" . $until_rest_portion . "')";
                } else {
                    $query .= " AND PREC_CP IN(SELECT PREC_CP FROM {$base_client}.client_exercito WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') )>='" . $rest_portion . "'  )";
                }
            }*/
        }
        if ($organ == 2) {


            if (count($bank_not_descounts) != 0) {
                $query .= " AND CPF not IN ( SELECT CPF FROM {$base_client}.client_marinha WHERE BANCO in (";
                foreach ($bank_not_descounts as $counter => $each) {
                    //$pieces_bank = explode(" - ",$each->bank);
                    if ($counter == 0) {
                        $query .= "'" . $each->bank . "'";
                    } else {
                        $query .= "," . "'" . $each->bank . "'";
                    }
                }
                $query .= " ) and TIPO='EMP' and PRAZO>=CURDATE()) ";
            }

            if (count($bank_descounts) != 0) {
                $query .= " AND CPF in ( SELECT CPF FROM {$base_client}.client_marinha WHERE BANCO in (";
                foreach ($bank_descounts as $counter => $each) {
                    if ($counter == 0) {
                        $query .= "'" . $each->bank . "'";
                    } else {
                        $query .= "," . "'" . $each->bank . "'";
                    }
                }

                $query .= ") and TIPO='EMP' and PRAZO>=CURDATE() ) ";
            }

            if ($portions == "0.00") {

                if ($until_portion != "0.00") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_marinha WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))<='" . $until_portion . "'  and TIPO='EMP' and PRAZO>=CURDATE())";
                }
            } else {

                if ($until_portion != "0.00") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_marinha WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) BETWEEN '" . $portions . "' AND '" . $until_portion . "'   and TIPO='EMP' and PRAZO>=CURDATE())";
                } else {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_marinha WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))>='" . $portions . "'  and TIPO='EMP' and PRAZO>=CURDATE())";
                }
            }

            if ($rest_portion == "0") {

                if ($until_rest_portion != "0") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_marinha WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') )<='" . $until_rest_portion . "' and TIPO='EMP' and PRAZO>=CURDATE())";
                }
            } else {
                if ($until_rest_portion != "0") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_marinha WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') ) BETWEEN '" . $rest_portion . "' AND '" . $until_rest_portion . "'   and TIPO='EMP' and PRAZO>=CURDATE())";
                } else {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_marinha WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') )>='" . $rest_portion . "'  and TIPO='EMP' and PRAZO>=CURDATE())";
                }
            }
        }
        if ($organ == 3) {


            if (count($bank_not_descounts) != 0) {
                $query .= " AND CPF not IN ( SELECT CPF FROM {$base_client}.client_aero WHERE BANCO in (";
                foreach ($bank_not_descounts as $counter => $each) {
                    //$pieces_bank = explode(" - ",$each->bank);
                    if ($counter == 0) {
                        $query .= "'" . $each->bank . "'";
                    } else {
                        $query .= "," . "'" . $each->bank . "'";
                    }
                }
                $query .= " ) and PRAZO>=CURDATE() ) ";
            }

            if (count($bank_descounts) != 0) {
                $query .= " AND CPF in ( SELECT CPF FROM {$base_client}.client_aero WHERE BANCO in (";
                foreach ($bank_descounts as $counter => $each) {
                    if ($counter == 0) {
                        $query .= "'" . $each->bank . "'";
                    } else {
                        $query .= "," . "'" . $each->bank . "'";
                    }
                }

                $query .= ") and PRAZO>=CURDATE() ) ";
            }

            if ($portions == "0.00") {

                if ($until_portion != "0.00") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_aero WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))<='" . $until_portion . "' and CPF not in (select CPF from {$base_client}.client_aero WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))>'" . $until_portion . "') and PRAZO>=CURDATE())";
                }
            } else {

                if ($until_portion != "0.00") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_aero WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) BETWEEN '" . $portions . "' AND '" . $until_portion . "'  and PRAZO>=CURDATE())";
                } else {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_aero WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))>='" . $portions . "' )";
                }
            }

            if ($rest_portion == "0") {

                if ($until_rest_portion != "0") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_aero WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') )<='" . $until_rest_portion . "' and PRAZO>=CURDATE())";
                }
            } else {
                if ($until_rest_portion != "0") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_aero WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') ) BETWEEN '" . $rest_portion . "' AND '" . $until_rest_portion . "'  and PRAZO>=CURDATE())";
                } else {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_aero WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') )>='" . $rest_portion . "'  and PRAZO>=CURDATE())";
                }
            }
        }
        if ($organ == 4) {

            if (count($bank_not_descounts) != 0) {
                $query .= " AND CPF not IN ( SELECT CPF FROM {$base_client}.client_siape WHERE BANCO in (";
                foreach ($bank_not_descounts as $counter => $each) {
                    //$pieces_bank = explode(" - ",$each->bank);
                    if ($counter == 0) {
                        $query .= "'" . $each->bank . "'";
                    } else {
                        $query .= "," . "'" . $each->bank . "'";
                    }
                }
                $query .= " ) and PRAZO>=CURDATE()) ";
            }

            if (count($bank_descounts) != 0) {
                $query .= " AND CPF in ( SELECT CPF FROM {$base_client}.client_siape WHERE BANCO in (";
                foreach ($bank_descounts as $counter => $each) {
                    if ($counter == 0) {
                        $query .= "'" . $each->bank . "'";
                    } else {
                        $query .= "," . "'" . $each->bank . "'";
                    }
                }

                $query .= ") and PRAZO>=CURDATE()) ";
            }

            if ($portions == "0.00") {

                if ($until_portion != "0.00") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_siape WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))<='" . $until_portion . "' and PRAZO>=CURDATE())";
                }
            } else {

                if ($until_portion != "0.00") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_siape WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) BETWEEN '" . $portions . "' AND '" . $until_portion . "' and PRAZO>=CURDATE())";
                } else {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_siape WHERE CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))>='" . $portions . "' and PRAZO>=CURDATE())";
                }
            }


            if ($rest_portion == "0") {

                if ($until_rest_portion != "0") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_siape WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') )<='" . $until_rest_portion . "' and PRAZO>=CURDATE())";
                }
            } else {
                if ($until_rest_portion != "0") {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_siape WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') ) BETWEEN '" . $rest_portion . "' AND '" . $until_rest_portion . "'  and PRAZO>=CURDATE())";
                } else {
                    $query .= " AND CPF IN(SELECT CPF FROM {$base_client}.client_siape WHERE TIMESTAMPDIFF(MONTH, DATE_FORMAT(NOW(), '%Y-%m-%d') ,DATE_FORMAT(LAST_DAY((STR_TO_DATE(PRAZO, '%Y-%m-%d'))), '%Y-%m-%d') )>='" . $rest_portion . "' and PRAZO>=CURDATE())";
                }
            }
        }
        $query .= " AND id not in (select client_id from blocked_client where account_id='" . User::UserLog()->account_id . "' )";
        $query .= " AND id not in (select client_id from schedulings where account_id='" . User::UserLog()->account_id . "' and user_id!='" . User::UserLog()->id . "' )";
        if ($ignore_actived_filters == 0) {
            $query .= " AND id not in (select client_id from filter_queue where account_id='" . User::UserLog()->account_id . "' and filter_id in(select id from filters where status_filter='ATIVO'))";
        }
        if ($attendance_retorn_id != 0) {
            $query .= " AND id in (select client_id from attendances where attendance_return_id='" . $attendance_retorn_id . "' and account_id='" . User::UserLog()->account_id . "' ";

            if ($attendence_of == "") {

                if ($until_attendence_of != "") {
                    $query .= " AND created_at <='" . $until_attendence_of . "' ";
                }
            } else {
                if ($until_attendence_of != "") {
                    $query .= " AND created_at BETWEEN '" . $attendence_of . "' AND '" . $until_attendence_of . "'  ";
                } else {
                    $query .= " AND created_at >='" . $attendence_of . "' ";
                }
            }


            $query .= " ) ";
        } else {
            if ($dont_ignore_client == 0) {
                $query .= " AND id not in (select client_id from attendances where account_id='" . User::UserLog()->account_id . "' ) ";
            } else {
                $query .= " AND id not in (select client_id from filter_queue_consult where account_id='" . User::UserLog()->account_id . "')  ";
            }
        }
        $query .= " ORDER BY rand() limit 4000";

        try {
            $clients = $connect->query($query);

            return $clients->fetchAll();
        } catch (Exception $e) {
            return 0;
        }
        //return $query;
    }

    public function returnClientContract($organ)
    {
        $base_client = User::UserLog()->base_client;
        $connect = Connect::getInstance();
        if ($organ == 1) {
			$query = "select BANCO as 'BANCO_EMPRES',PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) as VALOR from {$base_client}.client_exercito where CPF='" . $this->CPF . "' group by BANCO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))";
            //$query = "select BANCO_EMPR as 'BANCO_EMPRES',PRAZO,VALOR from {$base_client}.client_exercito where PREC_CP='" . $this->PREC_CP . "' group by BANCO_EMPR,PRAZO,VALOR";
        }
        if ($organ == 2) {
			$query = "select BANCO as 'BANCO_EMPRES',PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) as VALOR from {$base_client}.client_marinha where CPF='" . $this->CPF . "' and TIPO='EMP'  and PRAZO>=CURDATE() group by BANCO,PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))";
            //$query = "select BANCO_EMPRES,PRAZO,VALOR from {$base_client}.client_marinha where MATRICULA='" . $this->MATRICULA . "' and TIPO='EMP' and PRAZO>=CURDATE() group by BANCO_EMPRES,PRAZO,VALOR";
        }
        if ($organ == 3) {
            $query = "select BANCO_EMPRES,PRAZO,VALOR from(select BANCO as 'BANCO_EMPRES',STR_TO_DATE(CONCAT('1,',month(PRAZO),',',year(PRAZO)),'%d,%m,%Y')as PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) as VALOR from {$base_client}.client_aero where CPF='" . $this->CPF . "' and PRAZO>=CURDATE() ) as tab group by BANCO_EMPRES,PRAZO,VALOR";
			//$query = "select BANCO as 'BANCO_EMPRES',PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) as VALOR from {$base_client}.client_aero where CPF='" . $this->CPF . "' and PRAZO>=CURDATE() group by BANCO,PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))";
            //$query = "select BANCO as 'BANCO_EMPRES',FIM_DESCONTO as PRAZO,VALOR from {$base_client}.client_aero where CPF='" . $this->CPF . "' and FIM_DESCONTO>=CURDATE() group by BANCO,FIM_DESCONTO,VALOR";
        }
        if ($organ == 4) {
			$query = "select BANCO as 'BANCO_EMPRES',PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) as VALOR from {$base_client}.client_siape where CPF='" . $this->CPF . "' and PRAZO>=CURDATE() group by BANCO,PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))";
            //$query = "select BANCO as 'BANCO_EMPRES',RESTANTES as 'PRAZO',VALOR from {$base_client}.client_siape where MATRICULA='" . $this->MATRICULA . "' and RESTANTES>=CURDATE() group by BANCO,RESTANTES,VALOR";
        }
        $clients = $connect->query($query);
        return $clients->fetchAll();
        //return $query;
    }

    public function returnClientContractMarinha()
    {
        $base_client = User::UserLog()->base_client;
        $connect = Connect::getInstance();

        $query = "select BANCO as 'BANCO_EMPRES',PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) as VALOR,TIPO from {$base_client}.client_marinha where CPF='" . $this->CPF . "' and PRAZO>=CURDATE() group by BANCO,PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))";
        //$query = "select BANCO_EMPRES,PRAZO,VALOR,TIPO from {$base_client}.client_marinha where MATRICULA='" . $this->MATRICULA . "' group by BANCO_EMPRES,PRAZO,VALOR";


        $clients = $connect->query($query);
        return $clients->fetchAll();
        //return $query;
    }

    public function returnClientContractOthers($organ)
    {
        $base_client = User::UserLog()->base_client;
        $connect = Connect::getInstance();
		$query = "select BANCO as 'BANCO_EMPRES',PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2)) as VALOR from {$base_client}.client_marinha where CPF='" . $this->CPF . "' and PRAZO>=CURDATE() and TIPO='ND' group by BANCO,PRAZO,CAST(REPLACE(REPLACE(VALOR,'.',''),',','.') AS decimal(10,2))";
        //$query = "select BANCO_EMPRES,PRAZO,VALOR from {$base_client}.client_marinha where MATRICULA='" . $this->MATRICULA . "' and TIPO='ND' ";
        $clients = $connect->query($query);
        return $clients->fetchAll();
        //return $query;
    }

    public function returnClientBlocked()
    {
        $base_client = User::UserLog()->base_client;
        $connect = Connect::getInstance();
        $query = "SELECT MATRICULA,MATRICULA,CPF,NOME,description,CLIENT_ORGAN FROM blocked_client INNER JOIN {$base_client}.client on client_id={$base_client}.client.id
INNER JOIN attendance_returns ON blocked_client.motivo=attendance_returns.id where account_id='" . User::UserLog()->account_id . "' ";
        $clients = $connect->query($query);
        return $clients->fetchAll();
    }
}
