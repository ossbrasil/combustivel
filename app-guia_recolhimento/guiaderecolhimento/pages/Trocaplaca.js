import * as React from 'react';
import { TouchableOpacity, BackHandler, View, Text, Alert, ScrollView } from 'react-native';
import { Container, Content, Drawer, Input } from 'native-base';
import styles from '../estilo/style'
import Card_motorista from '../components/card_motorita'
import Icon from 'react-native-vector-icons/MaterialIcons'
import Icone from 'react-native-vector-icons/FontAwesome'
import api from '../services/api'
import AsyncStorage from '@react-native-community/async-storage';
import Sidebar from '../components/sidebar'





class Trocaplaca extends React.PureComponent {
    constructor(props) {
        super(props);
        this.state = {
            nome: '',
            cnh: '',
            placa: '',
            selectedItem: '',
        }
        this.carrega_infos()
    }

    closeDrawer = () => {
        this.drawer._root.close()
      }
      openDrawer = () => {
        this.drawer._root.open()
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

    confirmarPlaca = async () => {
        // //Verifica se os campos estão vazios
        if (!this.state.Placa) {
            Alert.alert('Por favor, informe a placa!');
        } else if (this.state.Placa == this.state.placa) {
            Alert.alert("Atenção", 'A placa informada é igual a placa atual!');
        } else {
            try {
                const response = await api.post('/evento/', {
                    "matricula": this.state.matricula,
                    "placa": this.state.Placa
                })

                if (response.data == "Placa não cadastrada, por verifique o valor informado!") {
                    Alert.alert("Atenção", response.data)
                } else {
                    // Alert.alert("Teste", JSON.stringify(response.data))

                    await AsyncStorage.setItem('infoCarro', JSON.stringify(response.data))

                    this.props.navigation.navigate('Home');

                    Alert.alert("Atenção", "Placa alterada com sucesso!")

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
            <Drawer
            ref={(ref) => { this.drawer = ref; }}
            content={<Sidebar navigation={this.props.navigation} />}
            onClose={() => this.closeDrawer()}>
                <ScrollView>
                    <View style={styles.backgroundHome}>
                        <View style={styles.card_placa}>
                            <Text style={styles.texto_placa_titulo}>Nome do motorista</Text>
                            <Text style={styles.texto_placa}>{this.state.nome}</Text>
                            <Text style={styles.texto_placa_titulo}>Matrícula</Text>
                            <Text style={styles.texto_placa}>{this.state.matricula}</Text>
                            <Text style={styles.texto_placa_titulo}>CNH</Text>
                            <Text style={styles.texto_placa}>{this.state.cnh}</Text>
                            <Text style={styles.texto_placa_titulo}>Placa do carro atual</Text>
                            <Text style={styles.texto_placa}>{this.state.placa}</Text>
                            <Text style={styles.texto_placa_titulo}>Modelo do carro atual</Text>
                            <Text style={styles.texto_placa}>{this.state.modelo}</Text>
                            <Text style={styles.texto_placa_titulo}>Contrato do carro atual</Text>
                            <Text style={styles.texto_placa}>{this.state.contrato}</Text>
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
                    {/* <View style={{ flex: 1, backgroundColor: 'white' }} /> */}
                </ScrollView>
                <View style={styles.footer}>
                    <TouchableOpacity style={{ padding: 5 }}>
                        <Icon name={'menu'} size={40} onPress={this.openDrawer} color={'white'} />
                    </TouchableOpacity>
                </View>

            </Drawer>
        );
    }
}

export default Trocaplaca;
