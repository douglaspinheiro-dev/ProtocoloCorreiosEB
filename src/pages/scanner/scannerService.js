import GraphqlService from 'src/services/GraphqlService'
import schema from './produtoSchema'
const graphqlService = new GraphqlService(schema)
export default graphqlService
