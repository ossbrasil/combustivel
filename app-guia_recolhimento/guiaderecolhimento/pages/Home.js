import React, { Component } from 'react';
import NotifService from '../components/NotifService';
import { TouchableOpacity, BackHandler, TextInput, View, StyleSheet, Text, ScrollView, Alert } from 'react-native';
import { Spinner, Header, Content, Form, Item, Picker, Drawer } from 'native-base';
import styles from '../estilo/style'
import Sidebar from '../components/sidebar'
import Icon from 'react-native-vector-icons/MaterialIcons'
import Icone from 'react-native-vector-icons/FontAwesome'
import api from '../services/api'
import AsyncStorage from '@react-native-community/async-storage';
import BackgroundTimer from 'react-native-background-timer';
import PushNotification from "react-native-firebase-push-notifications"
// import firebase from 'react-native-firebase';
// import firebase from '@react-native-firebase/app';

export default class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            ajudante: undefined,
            carregando: 0,
            guias: [],
            selectedItem: '',
            infoGuia: 0
        };

        this.notif = new NotifService(
            this.onRegister.bind(this),
            this.onNotif.bind(this),
        );
        // this.carregar()
        // this.carrega_infos()
    }

    //   teste = async () => {
    //         BackgroundTimer.runBackgroundTimer(() => {
    //             console.log("Teste")
    //             this.notif.localNotif()
    //         }, 30000);
    //     }

    carregar = async () => {
        this.atividadebackground()
        // this.carrega_infos()
    }

    selecionaAjudante(value) {
        this.setState({
            ajudante: value
        });
    }

    atividadebackground = async () => {
        BackgroundTimer.runBackgroundTimer(this.carrega_infos.bind(this), 30000);
    }

    carrega_infos = async () => {
        const dadosMot = await AsyncStorage.getItem('dadosMot')

        var jResponse = JSON.parse(dadosMot)

        var matricula = jResponse.matricula
        var nome = jResponse.nome
        var cnh = jResponse.cnh

        const infoCarro = await AsyncStorage.getItem('infoCarro')

        var jResponse = JSON.parse(infoCarro)

        var placa = jResponse.placa
        var modelo = jResponse.modelo
        var contrato = jResponse.contrato

        // Alert.alert("Teste", matricula)

        this.setState({
            matricula: matricula,
            nome: nome,
            cnh: cnh,
            placa: placa,
            modelo: modelo,
            contrato: contrato,
        })

        this.servico()
    }

    servico = async () => {
        // Alert.alert("Teste")
        try {
            // const response = await api.post('/consultaGuias/')
            const response = await api.post('/consultaGuias/', {
                "matricula": this.state.matricula,
                "placa": this.state.placa
            })

            var jResponse = JSON.stringify(response.data)


            // console.log(jResponse)

            // Alert.alert("Teste", jResponse)

            if (jResponse == '"Não existem Guias de Recolhimento para esse motorista"') {
                // Alert.alert("Teste", jResponse)
                this.setState({
                    carregando: 1,
                    infoGuia: 0,
                })
            } else {
                var contAtual = response.data.length

                var contGuia = await AsyncStorage.getItem('contGuia')


                if (contAtual > contGuia) {
                    // Alert.alert("Teste", "| lala " + contAtual + "|" + contGuia + "|")

                    this.notif.localNotif()
                }
                // Alert.alert("Lala", "| " + contAtual + "|" + contGuia + "|")

                var n = contAtual.toString()

                await AsyncStorage.setItem('contGuia', n)

                var jResponse = JSON.parse(jResponse)

                this.setState({
                    guias: jResponse,
                    carregando: 1,
                    infoGuia: 1
                })
            }


        } catch (error) {
            Alert.alert("Erro de conexão")
            this.setState({
                carregando: 0,
            })
        }
    }

    consultaGuia = async (id) => {
        // Alert.alert('Teste', id)
        await AsyncStorage.setItem('idGuia', id)

        this.props.navigation.navigate('Guiaservico');
    }


    closeDrawer = () => {
        this.drawer._root.close()
    }
    openDrawer = () => {
        this.drawer._root.open()
    }



    componentDidMount = () => {
        // console.log('Teste 1')

        this.carregar()
        this.carrega_infos()
    }

    componentWillUnmount = async () => {
        // console.log('Teste 2')
        BackgroundTimer.stopBackgroundTimer()

    }

    render() {
        return (

            <Drawer
                ref={(ref) => {
                    this.drawer = ref;
                }}
                content={< Sidebar navigation={this.props.navigation} />}
                onClose={() => this.closeDrawer()}>

                <ScrollView style={{ backgroundColor: 'white', }}>
                    <View style={styles.backgroundHome}>


                        <Text style={{ fontSize: 18, paddingTop: 30 }}>Informações do motorista</Text>

                        <View style={styles.backgroundHome}>
                            <View style={styles.card_motorista}>
                                <Text style={styles.texto_placa_titulo}>Nome do motorista</Text>
                                <Text style={styles.texto_placa}>{this.state.nome}</Text>
                                <Text style={styles.texto_placa_titulo}>CNH</Text>
                                <Text style={styles.texto_placa}>{this.state.cnh}</Text>
                                <Text style={styles.texto_placa_titulo}>Carro atual</Text>
                                <Text style={styles.texto_placa}>{this.state.modelo}</Text>
                                <Text style={styles.texto_placa_titulo}>Placa</Text>
                                <Text style={styles.texto_placa}>{this.state.placa}</Text>
                            </View>
                        </View>

                        {/* <Text style={{ fontSize: 18 }}>Selecione o ajudante</Text> */}

                        {/* <View style={styles.pickerAjudante}>
                        <Item picker>
                            <Picker
                                mode="dropdown"
                                style={{ width: undefined }}
                                placeholder="Selecione"
                                placeholderStyle={{ color: "#bfc6ea" }}
                                placeholderIconColor="#007aff"
                                selectedValue={this.state.ajudante}
                                onValueChange={this.selecionaAjudante.bind(this)}
                            >
                                <Picker.Item label="Por favor selecione" value="key0" />
                                <Picker.Item label="Juliana Zebrai" value="key1" />
                                <Picker.Item label="Debit Card" value="key2" />
                                <Picker.Item label="Credit Card" value="key3" />
                                <Picker.Item label="Net Banking" value="key4" />
                            </Picker>
                        </Item>
                    </View> */}
                        <Text style={{ fontSize: 18 }}>Guias em serviço</Text>

                        {(this.state.carregando == 0)
                            ?
                            <View style={styles.background}>
                                <Text style={{ fontSize: 26 }}>Carregando</Text>
                                <Spinner color='#ff5c54' />
                            </View>
                            :
                            <View style={styles.infoGuia}>
                                <ScrollView style={{ flex: 1 }}>
                                    {(this.state.infoGuia == 0)
                                        ?
                                        <View style={styles.cardGuiaHome}>
                                            <Text style={{ fontSize: 18, padding: 15 }}>No momento não existem guias de recolhimento ativas para esse motorista.</Text>
                                        </View>
                                        :
                                        <View style={styles.cardGuiaHome}>
                                            <ScrollView style={{ flex: 1 }}>

                                                {
                                                    this.state.guias.map((item) => {
                                                        return (
                                                            <TouchableOpacity
                                                                // onPress={this.consultaGuia.bind(this, item.id)}
                                                                // onPress={this.consultaGuia(item.id)}
                                                                onPress={() => this.consultaGuia(item.id)}
                                                            >
                                                                <View style={{ padding: 5, paddingLeft: 10, flexDirection: 'row', justifyContent: 'space-between' }} >
                                                                    <View>
                                                                        <View style={{ flexDirection: 'row' }}>
                                                                            <Text>Local</Text>
                                                                            <Icon name={'location-on'} size={18} color="#C0C0C0" style={{ paddingLeft: 5 }} />
                                                                        </View>
                                                                        <Text>{item.rua} - {item.numero}</Text>
                                                                        <Text>{item.bairro}</Text>
                                                                    </View>
                                                                    <View style={{ justifyContent: 'center', padding: 15 }}>
                                                                        <Icone name={'file-text'} size={35} color="#ff5c54" />
                                                                    </View>
                                                                </View>
                                                                <View style={styles.lineCinza} />
                                                            </TouchableOpacity>
                                                        )
                                                    })}
                                            </ScrollView>
                                        </View>
                                    }

                                </ScrollView>
                            </View>
                        }

                    </View>

                </ScrollView>
                <View style={{ flex: 1, backgroundColor: 'white' }} />

                <View style={styles.footer}>
                    <TouchableOpacity style={{ padding: 5 }}>
                        <Icon name={'menu'} size={40} onPress={this.openDrawer} color={'white'} />
                    </TouchableOpacity>
                </View>
            </Drawer >
        );
    }

    onRegister(token) {
        this.setState({ registerToken: token.token, fcmRegistered: true });
    }

    onNotif(notif) {
        Alert.alert(notif.title, notif.message);
    }

    handlePerm(perms) {
        Alert.alert('Permissions', JSON.stringify(perms));
    }
}
