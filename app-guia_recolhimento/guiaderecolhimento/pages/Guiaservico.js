import * as React from 'react';
import { TouchableOpacity, BackHandler, View, Text, Alert, TextInput, KeyboardAvoidingView, ScrollView } from 'react-native';
import { Container, Content, Drawer } from 'native-base';
import styles from '../estilo/style'
import Sidebar from '../components/sidebar'
import Icon from 'react-native-vector-icons/MaterialIcons'
import api from '../services/api'
import AsyncStorage from '@react-native-community/async-storage';



class Guiaservico extends React.PureComponent {
    constructor(props) {
        super(props);
        this.state = {
            estado: 0,
            selectedItem: '',
        }
        // this.carregaGuia()
        this.carrega_infos()
    }

    closeDrawer = () => {
        this.drawer._root.close()
    }
    openDrawer = () => {
        this.drawer._root.open()
    }

    coleta_assinatura = async () => {
        this.props.navigation.navigate('Assinatura');
    }

    carrega_infos = async () => {
        const idGuia = await AsyncStorage.getItem('idGuia')

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
            idGuia: idGuia,
            matricula: matricula,
            nome: nome,
            cnh: cnh,
            placa: placa,
            modelo: modelo,
            contrato: contrato,
        })

        this.carregaGuia()
    }

    carregaGuia = async () => {
        const idGuia = await AsyncStorage.getItem('idGuia')

        try {
            const response = await api.post('/infoGuia/', {
                "idGuia": idGuia,
            })

            var jResponse = JSON.stringify(response.data)

            var jResponse = JSON.parse(jResponse)

            let n_solicitacao = jResponse.n_solicitacao
            let dp_registro = jResponse.dp_registro
            let bo = jResponse.bo
            let nome_mae = jResponse.nome_mae
            let nome_falecido = jResponse.nome_falecido
            let rg_falecido = jResponse.rg_falecido
            let orgao_emissor = jResponse.orgao_emissor
            let causa_morte = jResponse.causa_morte
            let local_recolhimento = jResponse.local_recolhimento
            let rua = jResponse.rua
            let numero = jResponse.numero
            let bairro = jResponse.bairro
            let cep = jResponse.cep
            let ponto_referencia = jResponse.ponto_referencia
            let regiao = jResponse.regiao
            let nome_condutor = jResponse.nome_condutor
            let placa_veiculo = jResponse.placa_veiculo
            let data_retirada = jResponse.data_retirada
            let encaminhamento = jResponse.encaminhamento
            let obs = jResponse.obs
            let usuario_cadastro = jResponse.usuario_cadastro
            let hora_gravacao = jResponse.hora_gravacao
            let flag = jResponse.flag

            // Alert.alert('Teste', '| ' + n_solicitacao + ' |')

            this.setState({
                n_solicitacao: n_solicitacao,
                dp_registro: dp_registro,
                bo: bo,
                nome_mae: nome_mae,
                nome_falecido: nome_falecido,
                rg_falecido: rg_falecido,
                orgao_emissor: orgao_emissor,
                causa_morte: causa_morte,
                local_recolhimento: local_recolhimento,
                rua: rua,
                numero: numero,
                bairro: bairro,
                cep: cep,
                ponto_referencia: ponto_referencia,
                regiao: regiao,
                nome_condutor: nome_condutor,
                placa_veiculo: placa_veiculo,
                data_retirada: data_retirada,
                encaminhamento: encaminhamento,
                obs: obs,
                usuario_cadastro: usuario_cadastro,
                hora_gravacao: hora_gravacao,
                flag: flag,
            })


        } catch (error) {
            Alert.alert('Atenção', 'Erro ao carregar as informações,verifique sua conexão!');
        }
    }


    salvarAlteracoes = async () => {
        // Alert.alert("Teste")
        var assinaturaEncoded = await AsyncStorage.getItem('assinaturaEncoded')

        try {
            const response = await api.post('/salvarAlteracoes/', {
                "idGuia": this.state.idGuia,
                "nome_responsavel": this.state.nome_responsavel,
                "cpf_responsavel": this.state.cpf_responsavel,
                "tel_responsavel": this.state.telefone_responsavel,
                "assinatura": assinaturaEncoded
            })

            var jResponse = JSON.stringify(response.data)

            // Alert.alert("Teste", jResponse)
            // console.log(jResponse)
            Alert.alert("Atenção", "Coleta finalizada com sucesso!")

            this.props.navigation.navigate('Home');

        } catch (error) {
            Alert.alert("Erro de conexão")
        }
    }

    render() {
        return (
            <Drawer
                ref={(ref) => { this.drawer = ref; }}
                content={<Sidebar navigation={this.props.navigation} />}
                onClose={() => this.closeDrawer()}>

                <View style={styles.backgroundHistorico}>
                    <ScrollView>
                        {/* Inicio do card Informações do falecido */}
                        <Text style={styles.text_title}>Informações do falecido</Text>

                        <View style={styles.card_infoFalecido}>
                            <View style={{ padding: 5 }}>
                                <Text style={styles.text_note}>N° da solicitação</Text>
                                <Text style={styles.text_info}>{this.state.n_solicitacao}</Text>
                            </View>
                            <View style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                                <View style={{ padding: 5 }}>
                                    <Text style={styles.text_note}>B.O</Text>
                                    <Text style={styles.text_info}>{this.state.bo}</Text>
                                </View>
                                <View style={{ padding: 5 }}>
                                    <Text style={styles.text_note}>D.P de registro</Text>
                                    <Text style={styles.text_info}>{this.state.dp_registro}</Text>
                                </View>
                            </View>
                            <View style={{ padding: 5 }}>
                                <Text style={styles.text_note}>Nome do falecido</Text>
                                <Text style={styles.text_info}>{this.state.nome_falecido}</Text>
                            </View>
                            <View style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                                <View style={{ padding: 5 }}>
                                    <Text style={styles.text_note}>R.G</Text>
                                    <Text style={styles.text_info}>{this.state.rg_falecido}</Text>
                                </View>
                                <View style={{ padding: 5 }}>
                                    <Text style={styles.text_note}>Orgão Emissor</Text>
                                    <Text style={styles.text_info}>{this.state.orgao_emissor}</Text>
                                </View>
                            </View>
                            <View style={{ padding: 5 }}>
                                <Text style={styles.text_note}>Nome da mãe</Text>
                                <Text style={styles.text_info}>{this.state.nome_mae}</Text>
                            </View>
                        </View>
                        {/* Fim do card Informações do falecido */}

                        {/* Inicio do card Informações da retirada do corpo */}
                        <Text style={styles.text_title}>Informações da retirada do corpo</Text>

                        <View style={styles.card_infoFalecido}>
                            <View style={{ padding: 5 }}>
                                <Text style={styles.text_note}>Local</Text>
                                <Text style={styles.text_info}>{this.state.local_recolhimento}</Text>
                            </View>
                            <View style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                                <View style={{ padding: 5 }}>
                                    <Text style={styles.text_note}>Endereço</Text>
                                    <Text style={styles.text_info}>{this.state.rua}</Text>
                                </View>
                                <View style={{ padding: 5 }}>
                                    <Text style={styles.text_note}>N°</Text>
                                    <Text style={styles.text_info}>{this.state.numero}</Text>
                                </View>
                            </View>
                            <View style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                                <View style={{ padding: 5 }}>
                                    <Text style={styles.text_note}>Bairro</Text>
                                    <Text style={styles.text_info}>{this.state.bairro}</Text>
                                </View>
                                <View style={{ padding: 5 }}>
                                    <Text style={styles.text_note}>CEP</Text>
                                    <Text style={styles.text_info}>{this.state.cep}</Text>
                                </View>
                            </View>
                            <View style={{ padding: 5 }}>
                                <Text style={styles.text_note}>Nome do condutor</Text>
                                <Text style={styles.text_info}>{this.state.nome}</Text>
                            </View>
                            <View style={{ padding: 5 }}>
                                <Text style={styles.text_note}>Placa</Text>
                                <Text style={styles.text_info}>{this.state.placa_veiculo}</Text>
                            </View>
                        </View>
                        {/* Fim do card Informações da retirada do corpo */}

                        {/* Inicio do card Informações do responsavel */}
                        <Text style={styles.text_title}>Informações do responsável</Text>

                        <View style={styles.card_infoFalecido}>

                            <TextInput
                                keyboardType='default'
                                style={styles.input_guia}
                                placeholder={'Nome'}
                                // placeholderTextColor={"#D3D3D3"}
                                underlineColorAndroid='transparent'
                                onChangeText={(nome_responsavel) => this.setState({ nome_responsavel })}
                            />

                            <TextInput
                                keyboardType='numeric'
                                style={styles.input_guia}
                                placeholder={'CPF'}
                                // placeholderTextColor={"#D3D3D3"}
                                underlineColorAndroid='transparent'
                                onChangeText={(cpf_responsavel) => this.setState({ cpf_responsavel })}
                            />

                            <TextInput
                                keyboardType='numeric'
                                style={styles.input_guia}
                                placeholder={'Telefone'}
                                // placeholderTextColor={"#D3D3D3"}
                                underlineColorAndroid='transparent'
                                onChangeText={(telefone_responsavel) => this.setState({ telefone_responsavel })}
                            />
                        </View>
                        {/* Fim do card Informações do responsavel */}

                        <Text style={styles.text_title}>Assinatura do responsável</Text>

                        <View style={{ alignItems: 'center', }}>
                            <TouchableOpacity style={styles.btn_coleta} onPress={this.coleta_assinatura}>
                                <Text style={styles.txtbtn_coleta}>COLETAR ASSINATURA</Text>
                            </TouchableOpacity>

                            <TouchableOpacity style={styles.btn_coleta} onPress={this.salvarAlteracoes}>
                                <Text style={styles.txtbtn_coleta}>REALIZAR COLETA</Text>
                            </TouchableOpacity>
                        </View>
                    </ScrollView>


                    {/* <View style={{ flex: 1 }} /> */}
                    <View style={styles.footer}>
                        <TouchableOpacity style={{ padding: 5 }}>
                            <Icon name={'menu'} size={40} color={'white'} onPress={this.openDrawer} />
                        </TouchableOpacity>
                    </View>
                </View>
            </Drawer>
        );
    }
}

export default Guiaservico;
