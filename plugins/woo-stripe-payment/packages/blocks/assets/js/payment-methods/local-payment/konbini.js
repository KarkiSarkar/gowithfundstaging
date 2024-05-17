import {useEffect, useRef} from '@wordpress/element';
import {registerPaymentMethod} from '@woocommerce/blocks-registry';
import {ensureErrorResponse, getBillingDetailsFromAddress, getSettings, initStripe as loadStripe, isNextActionRequired, StripeError} from "../util";
import {PaymentMethod, PaymentMethodLabel} from "../../components/checkout";
import {canMakePayment, LocalPaymentIntentContent} from "./local-payment-method";
import {Elements, useStripe} from "@stripe/react-stripe-js";

const getData = getSettings('stripe_konbini_data');

if (getData()) {
    registerPaymentMethod({
        name: getData('name'),
        label: <PaymentMethodLabel
            title={getData('title')}
            paymentMethod={getData('name')}
            icons={getData('icon')}/>,
        ariaLabel: 'Konbini',
        placeOrderButtonLabel: getData('placeOrderButtonLabel'),
        canMakePayment: canMakePayment(getData),
        content: <PaymentMethod content={LocalPaymentIntentContent} getData={getData}/>,
        edit: <PaymentMethod content={LocalPaymentIntentContent} getData={getData}/>,
        supports: {
            showSavedCards: false,
            showSaveOption: false,
            features: getData('features')
        }
    })
}