import React, { Component } from 'react';
import { TouchableOpacity, BackHandler, FlatList, View, SafeAreaView } from 'react-native';
import { Left, Body, Text, Thumbnail, Card, CardItem, Item, Input, Spinner, Grid } from 'native-base';
import styles from '../estilo/style'


export default class Card_motorista extends Component {

    state = {
        nome: null,
    };

    constructor(props) {
        super(props)
    }

    render() {
        return (
            <View style={styles.backgroundHome}>
                <View style={styles.card_motorista}>
                    <Text note>Nome do motorista</Text>
                    <Text >Gabriel Cavalcante de Lima</Text>
                    <Text note>CNH</Text>
                    <Text >48.587.99/85</Text>
                    <Text note>Carro atual</Text>
                    <Text >Volksvagem Saveiro</Text>
                    <Text note>Placa</Text>
                    <Text >KHF-8854</Text>
                </View>
            </View>
        );
    }
}


