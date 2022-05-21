<?php

namespace Source\App;

use Source\Models\Attendance;
use Source\Models\Filter;
use Source\Models\User;
use Source\Models\Log;
use Source\Models\Ticket as TicketModel;

/**
 * Description of Dash
 *
 * @author Luiz
 */
class Dash extends Admin
{

  /**
   * Dash constructor.
   */
  public function __construct($router)
  {
    parent::__construct($router);
  }

  /**
   *
   */
  public function dash(): void
  {
    redirect("/dash/estrategico");
  }

  /**
   * @param array|null $data
   * @throws \Exception
   */
  public function home(?array $data): void
  {
    $tickets = (new TicketModel())->getUnpaidTicketsOfClientOrderedByDueDate(); // model
    $firstTicketToPay = $tickets[0] ?? null;

    if ($this->user->client == 1) {
      $users = (new User())->find("status!=2 and client=1 and account_id=:id and admin_account=0", "id={$this->user->account_id}")->count();
    } else {
      $users = (new User())->find("status!=2 and client=1 and  admin_account=0")->count();
    }

    if ($this->user->level_id == 1) {
      $filter_active = (new Filter())->find("status!=2 and account_id=:id and status_filter='ATIVO'", "id={$this->user->account_id}")->count();
    } else {
      $filter_active = (new Filter())->find("status!=2 and account_id=:id and status_filter='ATIVO' and id in (select filter_id from filter_users where user_id='" . $this->user->id . "') ", "id={$this->user->account_id}")->count();
    }

    if ($this->user->level_id == 1) {
      $filter_pause = (new Filter())->find("status!=2 and account_id=:id and status_filter='PAUSADO'", "id={$this->user->account_id}")->count();
    } else {
      $filter_pause = (new Filter())->find("status!=2 and account_id=:id and status_filter='PAUSADO' and id in (select filter_id from filter_users where user_id='" . $this->user->id . "') ", "id={$this->user->account_id}")->count();
    }

    $attandance_team = (new Attendance())->find("status!=2 and account_id=:id", "id={$this->user->account_id}")->count();
    $attandance_personal = (new Attendance())->find("status!=2 and account_id=:id and user_id=:user", "id={$this->user->account_id}&user={$this->user->id}")->count();
    
    $head = $this->seo->render(
      CONF_SITE_NAME . " | Dashboard Estratégico",
      CONF_SITE_DESC,
      url("/"),
      theme("/assets/images/image.png", CONF_VIEW_THEME_ADMIN),
      false
    );

    echo $this->view->render("dash/dashboard1", [
      "menu" => "dash",
      "submenu" => "dash",
      "head" => $head,
      "users" => $users,
      "filter_active" => $filter_active,
      "filter_pause" => $filter_pause,
      "attandance_team" => $attandance_team,
      "attandance_personal" => $attandance_personal,
      "scheduling" => "",
      "ticketToPay" => $firstTicketToPay,
    ]);
  }

  public function log(?array $data): void
  {

    if ($this->user->client != 0) {
      $log = (new Log())->find("DATE(created_at) = DATE(now()) and account_id=:account", "account={$this->user->account_id}")->order("id DESC")->fetch(true);
    } else {
      $log = (new Log())->find("DATE(created_at) = DATE(now())")->order("id DESC")->fetch(true);
    }

    $head = $this->seo->render(
      CONF_SITE_NAME . " | Log",
      CONF_SITE_DESC,
      url("/"),
      theme("/assets/images/image.png", CONF_VIEW_THEME_ADMIN),
      false
    );

    echo $this->view->render("dash/log", [
      "menu" => "log",
      "submenu" => "log",
      "head" => $head,
      "log" => $log
    ]);
  }
}
