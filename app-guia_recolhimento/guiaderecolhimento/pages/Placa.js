import * as React from 'react';
import { TouchableOpacity, BackHandler, View, Text, Alert, } from 'react-native';
import { Container, Content, Drawer, Input } from 'native-base';
import styles from '../estilo/style'
import Card_motorista from '../components/card_motorita'
import Icon from 'react-native-vector-icons/MaterialIcons'
import Icone from 'react-native-vector-icons/FontAwesome'
import api from '../services/api'
import AsyncStorage from '@react-native-community/async-storage';




class Placa extends React.PureComponent {
    constructor(props) {
        super(props);
        this.state = {
            nome: '',
            cnh: '',
            placa: '',
        }
        this.carrega_infos()
    }


    carrega_infos = async () => {
        const dadosMot = await AsyncStorage.getItem('dadosMot')

        var jResponse = JSON.parse(dadosMot)

        var matricula = jResponse.matricula
        var nome = jResponse.nome
        var cnh = jResponse.cnh

        // Alert.alert("Teste", matricula)

        this.setState({
            matricula: matricula,
            nome: nome,
            cnh: cnh,

        })

    }

    confirmarPlaca = async () => {
        // //Verifica se os campos estão vazios
        if (!this.state.Placa) {
            Alert.alert('Por favor, informe a placa!');
        } else {
            try {
                const response = await api.post('/evento/', {
                    "matricula": this.state.matricula,
                    "placa": this.state.Placa
                })

                if( response.data == "Placa não cadastrada, por verifique o valor informado!") {
                    Alert.alert("Atenção", response.data)
                } else {
                    // Alert.alert("Teste", JSON.stringify(response.data))

                    await AsyncStorage.setItem('infoCarro', JSON.stringify(response.data))

                    this.props.navigation.navigate('Home');
                }

            } catch (error) {
                // console.log(loginOff)
                Alert.alert('Erro na confirmação, verifique sua conexão!');
            }
        }
    };

    listarPlacaVeiculos = async (placaInput) => {


        if (placaInput.length == 7 && !placaInput.includes("-")) {
            var metade = Math.floor(placaInput.length - 4);
            var resultado = placaInput.substr(0, metade) + "-" + placaInput.substr(metade);

            await this.setState({
                Placa: resultado.toUpperCase()
            })

            return;
        } else if (placaInput.length > 3 && placaInput.includes("-")) {
            await this.setState({
                Placa: placaInput
            })
        }

        if (placaInput == '' || placaInput == ' ') {
            this.setState({
                placasVeiculos: [],
                loadinFlatlist: false,
                Placa: null,
            })
        } else {

            const { placasVeiculosCompleta } = this.state

            var teste = placasVeiculosCompleta.filter(text => text.placa.includes(placaInput))

            // console.log(teste)
            this.setState({
                placasVeiculos: teste.length < 1 ? null : teste,
                loadinFlatlist: teste.length < 1 ? false : true,
            })
        }
    }

    // renderItem = ({ item }) => (
    //     <View style={{ zIndex: 10, }}>
    //         <TouchableOpacity style={{ width: '100%', borderBottomColor: '#fff', justifyContent: 'center', borderBottomWidth: 1, height: 40 }} onPress={() => {
    //             this.setState({
    //                 Placa: item.placa,
    //                 loadinFlatlist: false
    //             })
    //         }}>
    //             <Text style={{ fontSize: 17, textAlignVertical: "center", textAlign: 'center' }}>
    //                 {item.placa}
    //             </Text>
    //         </TouchableOpacity>

    //     </View>
    // )

    render() {
        return (
            <View style={styles.backgroundHome}>
                <View style={styles.card_placa}>
                    <Text style={styles.texto_placa_titulo}>Nome do motorista</Text>
                    <Text style={styles.texto_placa}>{this.state.nome}</Text>
                    <Text style={styles.texto_placa_titulo}>Matrícula</Text>
                    <Text style={styles.texto_placa}>{this.state.matricula}</Text>
                    <Text style={styles.texto_placa_titulo}>CNH</Text>
                    <Text style={styles.texto_placa}>{this.state.cnh}</Text>
                </View>
                <Text style={{ fontSize: 20 }}>Por favor informe a placa!</Text>
                <View style={styles.input_placa}>
                    <Input
                        style={{ fontSize: 30 }}
                        value={this.state.Placa}
                        autoCapitalize={'characters'}
                        returnKeyLabel={"next"}
                        keyboardType={'name-phone-pad'}
                        maxLength={8}
                        onChangeText={(text) => this.listarPlacaVeiculos(text.toUpperCase())}


                    />
                </View>
                <TouchableOpacity style={styles.btn_coleta} onPress={this.confirmarPlaca}>
                    <Text style={styles.txtbtn_coleta}>CONFIRMAR</Text>
                </TouchableOpacity>

                {
                    this.state.loadinFlatlist == true ?
                        <SafeAreaView>

                            <FlatList
                                style={{ zIndex: 10, elevation: 20, backgroundColor: '#DCDCDC', position: 'absolute', width: '50%', height: 300 }}
                                keyExtractor={item => String(item.id)}
                                renderItem={this.renderItem}
                                data={this.state.placasVeiculos}
                            />
                        </SafeAreaView>
                        : null
                }


            </View >
        );
    }
}

export default Placa;
