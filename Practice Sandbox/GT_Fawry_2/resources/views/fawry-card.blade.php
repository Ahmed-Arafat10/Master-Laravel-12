@section('css')
    <style>
        /* Colors */
        /* General */
        html {
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            box-sizing: border-box;
            font-size: 62.5%;
        }

        html * {
            box-sizing: inherit;
        }

        body {
            background: linear-gradient(135deg, #0f6ab0, #053f6f);
            /*display: grid;*/
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.6rem;
            min-height: 100vh;
            place-content: center;
        }

        /* Layout */
        .cc {
            align-items: center;
            display: flex;
            flex-direction: column;
            gap: 4rem;
        }

        @media (min-width: 800px) {
            .cc {
                gap: 6.4rem;
                flex-direction: row;
            }
        }

        /* Form */
        form {
            color: white;
            max-width: 100%;
            width: 260px;
        }

        fieldset {
            appearance: none;
            border: none;
            display: grid;
            gap: 2.4rem;
            grid-template-columns: 1fr 1fr;
            padding: 0;
        }

        legend {
            font-size: 3.2rem;
            margin-bottom: 2.4rem;
            padding: 0;
        }

        label {
            display: block;
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 0.1rem;
            text-transform: uppercase;
        }

        input[type="text"] {
            appearance: none;
            background: none;
            border: none;
            border-bottom: 1px solid white;
            color: white;
            display: block;
            font-family: 'Source Sans 3';
            font-size: 1.8rem;
            outline: none;
            padding: 0.4rem 0;
            width: 100%;
        }

        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.6rem;
        }

        input[type="text"]:focus {
            border-color: #89cb75;
        }

        input[type="submit"] {
            appearance: none;
            background-color: #89cb75;
            border: none;
            border-radius: 0.2rem;
            color: black;
            cursor: pointer;
            font-family: 'Source Sans 3';
            font-size: 1.8rem;
            justify-self: start;
            margin-top: -1.6rem;
            padding: 0.8rem 1.6rem;
        }

        input[type="submit"][disabled] {
            background-color: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        .fieldgroup {
            grid-column: -1;
            margin-bottom: 1.6rem;
        }

        .fieldgroup--half {
            grid-column: unset;
        }

        /* Credit Card */
        .cc__card {
            border-radius: 0.8rem;
            box-shadow: 0 0.8rem 4rem rgba(0, 0, 0, 0.2);
            display: flex;
            flex-wrap: wrap;
            gap: 2.4rem;
            justify-content: space-between;
            padding: 2.4rem;
            position: relative;
            width: 42rem;
            z-index: 1;
        }

        .cc__card::before {
            background: linear-gradient(#c1d9eb, #3f86be);
            border-radius: 0.8rem;
            content: '';
            position: absolute;
            top: -0.1rem;
            left: -0.1rem;
            bottom: -0.1rem;
            right: -0.1rem;
            z-index: -2;
        }

        .cc__card::after {
            background-color: #5994c2;
            border-radius: 0.8rem;
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: -1;
        }

        .cc__logo {
            margin-bottom: 1.6rem;
            width: 3.6rem;
        }

        .cc__cardgroup {
            flex-grow: 1;
        }

        .cc__cardgroup--wide {
            flex-basis: 100%;
        }

        .cc__card-label {
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 0.1rem;
            text-transform: uppercase;
        }

        .cc__card-value {
            color: white;
            height: 3.2rem;
            line-height: 3.2rem;
        }

        .cc__card-value--large {
            font-family: 'PT Mono', monospace;
            font-size: 2.4rem;
            height: 4.8rem;
            line-height: 4.8rem;
        }

    </style>
@endsection
@extends('main-layout')
@section('main-div')
    <div
        class="cc"
        x-data="{
		fields: {
			cardnumber: '',
			cardholder: '',
			exp: '',
			cvc: '',
		},
		valid: false,
		formatCardNumber(number) {
			return number.replace(/[^0-9]/gi, '').slice(0, 16).replace(/(.{4})/g, '$1 ').trim();
		},
		formatExp(number) {
			return number.replace(/[^0-9]/gi, '').slice(0, 4).replace(/(.{2})/, '$1\/').trim();
		},
		validate() {
			 let valid = true;
			 for (const value in this.fields) {
			 	if (this.fields[value].length < 1) {
			 		valid = false;
			 	}
			 }
			 this.valid = valid;
		}
	}"
    >

        <div class="cc__card">
            <div class="cc__logo">
                <svg viewBox="0 0 35.31 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#e60019" stroke-width="0"
                          d="m12 24-12-12 12-12 5.66 5.66-6.34 6.34 6.34 6.34-5.66 5.66z"/>
                    <path fill="#f69f24" stroke-width="0"
                          d="m23.31 0 12 12-12 12-5.66-5.66 6.34-6.34-6.34-6.34 5.66-5.66z"/>
                    <rect fill="#f85c1d" stroke-width="0" transform="translate(-3.31 16) rotate(-45)" x="13.17" y="7.52"
                          width="8.97" height="8.97"/>
                </svg>
            </div>
            <div class="cc__cardgroup cc__cardgroup--wide">
                <div class="cc__card-label">Card Number</div>
                <div class="cc__card-value cc__card-value--large" x-text="fields.cardnumber"></div>
            </div>
            <div class="cc__cardgroup">
                <div class="cc__card-label">Cardholder</div>
                <div class="cc__card-value" x-text="fields.cardholder"></div>
            </div>
            <div class="cc__cardgroup">
                <div class="cc__card-label">Expires</div>
                <div class="cc__card-value" x-text="fields.exp"></div>
            </div>
            <div class="cc__cardgroup">
                <div class="cc__card-label">CVC</div>
                <div class="cc__card-value" x-text="fields.cvc"></div>
            </div>
        </div>

        <form method="post" action="{{ route('fawry.card.store') }}" class="cc__form" @submit.prevent
              @keyup="validate()">
            @csrf
            <fieldset>
                <legend>Payment Details</legend>
                <div class="fieldgroup">
                    <label for="card-number">Card Number</label>
                    <input id="card-number" required name="card_number" type="number" tabindex="1"
                           x-model="fields.cardnumber"
                           @keydown="if (fields.cardnumber.length > 18 && $event.keyCode != 8 && $event.keyCode != 9 && $event.keyCode != 46) { $event.preventDefault(); }"
                           @keyup="fields.cardnumber = formatCardNumber(fields.cardnumber)"/>
                </div>
                <div class="fieldgroup">
                    <label for="cardholder">Cardholder</label>
                    <input id="cardholder" name="card_holder" type="text" tabindex="2" x-model="fields.cardholder"
                           @keydown="if (fields.cardholder.length > 24 && $event.keyCode != 8 && $event.keyCode != 9 && $event.keyCode != 46) { $event.preventDefault(); }"/>
                </div>
                <div class="fieldgroup fieldgroup--half">
                    <label for="card-exp">Expires</label>
                    <input id="card-exp" required name="expire" type="text" placeholder="MM/YY" tabindex="3"
                           x-model="fields.exp"
                           @keydown="if (fields.exp.length > 4 && $event.keyCode != 8 && $event.keyCode != 9 && $event.keyCode != 46) { $event.preventDefault(); }"
                           @keyup="fields.exp = formatExp(fields.exp)"/>
                </div>
                <div class="fieldgroup fieldgroup--half">
                    <label for="card-cvc">CVV</label>
                    <input id="card-cvc" required name="cvv" type="text" tabindex="4" x-model="fields.cvc"
                           @keydown="if (fields.cvc.length > 2 && $event.keyCode != 8 && $event.keyCode != 9 && $event.keyCode != 46) { $event.preventDefault(); }"/>
                </div>
                <input class="button" type="submit" value="Add Card" tabindex="5" x-bind:disabled="!valid"/>
            </fieldset>
        </form>

    </div>
@endsection

