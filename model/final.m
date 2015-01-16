%%Final Assignment
%Model of dynamic networks based on a homophily principle- Last FM user
%categorization

%%the number of states that agent has
%1 - opinion(preference) of an agent about rock 
%2 - opinion(preference) of an agent about jazz
%2 - opinion(preference) of an agent about pop
%2 - opinion(preference) of an agent about electronic
number_states=4;

%time steps taken in the simulation
timesteps=40;

%number of agents in the network
number_agents=96;



delta_t=0.01;

%the connection strenghts between all of the agents
influences=zeros(number_agents,number_agents,timesteps/delta_t);


%initial values of the influence matrix- a product of the three factors
%mentioned below
expressiveness=zeros(number_agents,1);
openness=zeros(number_agents,1);

%number of recently lisened tracks in the last month for each agent(to be taken from the last.fm data)
%to be used as a value for expressivness of the agents

recently_listened=load('expressiveness');
recently_listened=recently_listened.b;

agent_states=load('initialopinions');
agent_states=agent_states.a;

channel_strenght=load('strenghts');
channel_strenght=channel_strenght.c;

max_number=max(recently_listened);



for i=1:number_agents
    
%the main diagonal values of this matrix (containing the influence that an agent has to itself) should be set to 0
influences(i,i,:)=0;

%calculating agent expressivness
expressiveness(i)=recently_listened(i)/max_number;

%calculating agent openness
%taking into account the initial states of each agent
[value index]=max(agent_states(i,:,1));
%needed for calculating the openness
diff=zeros(number_states,1);

    for s=1:4
        
        threshold_count=0;
        diff(s)=agent_states(i,index,1)-agent_states(i,s,1);
    
        if 0<diff(s) && diff(s)<0.2
        threshold_count=threshold_count+1;
        end
        
    end
    
   % assigning a random value between 0 and 0.5 for the openness
    if threshold_count==0
        openness(i)=rand(1)/2;
    end
    if threshold_count==1
        openness(i)=rand(1)*0.2+0.5;
    end
    if threshold_count==2
        openness(i)=rand(1)*0.2+0.7;
    end
    if threshold_count==3
        openness(i)=1;
    end
     
end

%setting the initial influences of the agents
for i=1:number_agents
    for j=1:number_agents
    influences(i,j,1)=expressiveness(i)*openness(j)*channel_strenght(i,j);
    end
end


%how fast the agent adjusts to the opinion of other agents
eta=zeros(number_agents,1);
eta(:,1)=rand(number_agents,1)*0.5+0.5;

dif=zeros(number_agents,number_states);

alpha=15;
betha=0.01;

%the simulation- change the state value when need to calculate the
%appropriate opinion state and plot the graph
for t=1:timesteps/delta_t
    for i=1:number_agents
             sum=0;
                       
                for j=1:number_agents
        
                if i~=j
                sum=sum+influences(j,i,t)*(agent_states(j,1,t)-agent_states(i,1,t));
                end
                   
                influences(i,j,t+1)=influences(i,j,t)+influences(i,j,t)*alpha.*(betha-(agent_states(i,1,t)-agent_states(j,1,t)).^2).*(1-influences(i,j,t))*delta_t;
                end
          
             agent_states(i,1,t+1)=agent_states(i,1,t)+eta(i)*sum*delta_t;
     end
end

agents_state1=agent_states(:,1,:);
% agents_state2=agent_states(:,2,:);
% agents_state3=agent_states(:,3,:);
% agents_state4=agent_states(:,4,:);

%plot-state1
for a=1:number_agents
    plot(agents_state1(a,:));
    hold on;
end
