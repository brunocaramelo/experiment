"use stric";

class Financing {
  #term = 0;
  #tax = 0;
  #installment = 0;
  #total = 0;
  #totalPayment = 0;
  #fee = 0;

  #alreadValid = false;
  #hasError = false;

  #equationSolverActive = false;
  #equationSolverUrl = "https://www.wolframalpha.com/input?i2d=true&i=";
  #baseEq = "q=Divide[1-Power[\\(40)1+j\\(41),-n],j]p";

  constructor() {}

  get hasError() {
    return this.#hasError;
  }

  get term() {
    if (!this.#performCalcs()) return;

    this.#hasError = isNaN(this.#term) || this.#term == undefined;

    return this.#term;
  }

  get tax() {
    if (!this.#performCalcs()) return;

    this.#hasError = isNaN(this.#tax) || this.#tax == undefined;

    return this.#tax * 100;
  }

  get installment() {
    if (!this.#performCalcs()) return;

    this.#hasError = isNaN(this.#installment) || this.#installment == undefined;

    return this.#installment;
  }

  get total() {
    if (!this.#performCalcs()) return;

    this.#hasError = isNaN(this.#total) || this.#total == undefined;

    return this.#total;
  }

  get totalPayment() {
    if (!this.#performCalcs()) return;

    this.#hasError =
      isNaN(this.#totalPayment) || this.#totalPayment == undefined;

    return this.#totalPayment;
  }

  get fee() {
    if (!this.#performCalcs()) return;

    this.#hasError = isNaN(this.#fee) || this.#fee == undefined;

    return this.#fee;
  }

  set term(value) {
    this.#term = value < 0 ? 0 : value * 1;
  }

  set tax(value) {
    this.#tax = value < 0 ? 0 : value * 0.01 * 1;
  }

  set installment(value) {
    this.#installment = value < 0 ? 0 : value * 1;
  }

  set total(value) {
    this.#total = value < 0 ? 0 : value * 1;
  }

  /**
   * @param {boolean} value
   */
  set equationSolverActive(value) {
    this.#equationSolverActive = value;
  }

  #calcTotal() {
    this.#total = this.#pv(this.#tax, this.#term, this.#installment);

    if(this.#equationSolverActive) {
      var eq = this.#buildEq(
        0,
        this.#tax,
        this.#term,
        this.#installment
      );

      console.log(
        this.#equationSolverUrl +
        encodeURIComponent(eq)
      );
    }

    return this.#total;
  }

  #calcTotalPayment() {
    this.#totalPayment = this.#fv(
      this.#tax,
      this.#term,
      this.#installment
    );

    return this.#totalPayment;
  }

  #calcTerm() {
    this.#term = this.#nper(this.#tax, this.#installment, this.#total);

    if(this.#equationSolverActive) {
      var eq = this.#buildEq(
        this.#total,
        this.#tax,
        0,
        this.#installment
      );

      console.log(
        this.#equationSolverUrl +
        encodeURIComponent(eq)
      );
    }

    return this.#term;
  }

  #calcInstallment() {
    this.#installment = this.#pmt(
      this.#tax,
      this.#term,
      this.#total
    );

    if(this.#equationSolverActive) {
      var eq = this.#buildEq(
        this.#total,
        this.#tax,
        this.#term,
        0
      );

      console.log(
        this.#equationSolverUrl +
        encodeURIComponent(eq)
      );
    }

    return this.#installment;
  }

  #calcTax() {
    this.#tax = this.#rate(this.#term, this.#installment, this.#total);

    if(this.#equationSolverActive) {
      var eq = this.#buildEq(
        this.#total,
        0,
        this.#term,
        this.#installment
      );

      console.log(
        this.#equationSolverUrl +
        encodeURIComponent(eq)
      );
    }

    return this.#tax;
  }

  #calcFee() {
    this.#fee = Math.abs((this.#term * this.#installment) - this.#total);

    return this.#fee;
  }

  #buildEq(q, j, n, p) {
    var eq = this.#baseEq;

    if(q > 0) eq = eq.replace(/q/g, q);
    if(j > 0) eq = eq.replace(/j/g, j);
    if(n > 0) eq = eq.replace(/n/g, n);
    if(p > 0) eq = eq.replace(/p/g, p);

    return eq;
  }

  #performCalcs() {
    if (this.#validadeProperties()) {
      if (this.#tax <= 0) this.#calcTax();
      if (this.#term <= 0) this.#calcTerm();
      if (this.#installment <= 0) this.#calcInstallment();
      if (this.#total <= 0) this.#calcTotal();
      if (this.#totalPayment <= 0) this.#calcTotalPayment();
      if (this.#fee <= 0) this.#calcFee();

      return true;
    }

    return false;
  }

  #validadeProperties() {
    if (this.#alreadValid) return true;

    var countZero = 0;

    if (this.#term <= 0) countZero++;
    if (this.#tax <= 0) countZero++;
    if (this.#installment <= 0) countZero++;
    if (this.#total <= 0) countZero++;

    if (isNaN(this.#term) || this.#term % 1 !== 0 || this.#term < 0) {
      console.error("'meses' não é um número inteiro válido");

      return false;
    } else if (isNaN(this.#tax) || this.#tax < 0) {
      console.error("'taxa' não é um número válido");

      return false;
    } else if (isNaN(this.#installment) || this.#installment < 0) {
      console.error("'parcela' não é um número válido");

      return false;
    } else if (isNaN(this.#total) || this.#total < 0) {
      console.error("'total financiado' não é um número válido");

      return false;
    }

    if (countZero > 2) {
      console.error("preencha ao menos 3 campos!");

      return false;
    } else if (countZero <= 0) {
      console.error(
        "deixe um dos campos vazio com com zero, para executar o cálculo!"
      );

      return false;
    }

    this.#alreadValid = true;

    return this.#alreadValid;
  }

  /**
   * Port RATE function, from Excel
   */
  #rate(periods, payment, present, future, type, guess) {
    payment = -payment;

    guess = guess === undefined ? 0.01 : guess;
    future = future === undefined ? 0 : future;
    type = type === undefined ? 0 : type;

    var epsMax = 1e-10;
    var iterMax = 20;
    var rate = guess;

    type = type ? 1 : 0;

    for (var i = 0; i < iterMax; i++) {
      if (rate <= -1) {
        return error.num;
      }

      var y, f;

      if (Math.abs(rate) < epsMax) {
        y =
          present * (1 + periods * rate) +
          payment * (1 + rate * type) * periods +
          future;
      } else {
        f = Math.pow(1 + rate, periods);
        y = present * f + payment * (1 / rate + type) * (f - 1) + future;
      }

      if (Math.abs(y) < epsMax) {
        return rate;
      }

      var dy;

      if (Math.abs(rate) < epsMax) {
        dy = present * periods + payment * type * periods;
      } else {
        f = Math.pow(1 + rate, periods);
        var df = periods * Math.pow(1 + rate, periods - 1);
        dy =
          present * df +
          payment * (1 / rate + type) * df +
          payment * (-1 / (rate * rate)) * (f - 1);
      }

      rate -= y / dy;
    }

    return rate;
  }

  /**
   * Port NPER function, from Excel
   */
  #nper(rate, payment, present, future, type) {
    present = -present;

    type = type === undefined ? 0 : type;
    future = future === undefined ? 0 : future;

    if (rate === 0) {
      return -(present + future) / payment;
    } else {
      var num = payment * (1 + rate * type) - future * rate;
      var den = present * rate + payment * (1 + rate * type);

      return Math.log(num / den) / Math.log(1 + rate);
    }
  }

  /**
   * Port PV function, from Excel
   */
  #pv(rate, periods, payment, future, type) {
    payment = -payment;

    future = future || 0;
    type = type || 0;

    // Return present value
    if (rate === 0) {
      return -payment * periods - future;
    } else {
      return (
        (((1 - Math.pow(1 + rate, periods)) / rate) *
          payment *
          (1 + rate * type) -
          future) /
        Math.pow(1 + rate, periods)
      );
    }
  }

  /**
   * Port PMT function, from Open Office
   */
  #pmt(rate, periods, present, future, type) {

    present = -present;

    future = future || 0
    type = type || 0

    // Return payment
    var result
  
    if (rate === 0) {
      result = (present + future) / periods
    } else {
      var term = Math.pow(1 + rate, periods)
  
      if (type === 1) {
        result = ((future * rate) / (term - 1) + (present * rate) / (1 - 1 / term)) / (1 + rate)
      } else {
        result = (future * rate) / (term - 1) + (present * rate) / (1 - 1 / term)
      }
    }
  
    return -result
  }

  /**
   * Port PMT function, from Open Office
   */
  #fv(rate, periods, payment, value, type) {
    payment = -payment;

    value = value || 0
    type = type || 0

    // Return future value
    let result
  
    if (rate === 0) {
      result = value + payment * periods
    } else {
      var term = Math.pow(1 + rate, periods)
  
      if (type === 1) {
        result = value * term + (payment * (1 + rate) * (term - 1)) / rate
      } else {
        result = value * term + (payment * (term - 1)) / rate
      }
    }
  
    return -result
  }
}
